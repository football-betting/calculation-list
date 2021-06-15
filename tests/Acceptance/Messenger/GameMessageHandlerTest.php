<?php declare(strict_types=1);

namespace App\Tests\Acceptance\Messenger;

use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Messenger\GameMessageHandler;
use App\Redis\RedisRepository;
use App\Redis\RedisService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameMessageHandlerTest extends KernelTestCase
{
    private ?object $entityManager;
    private ?RedisRepository $redisRepository;
    private ?GameMessageHandler $gameMessageHandler;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->entityManager = self::$container
            ->get('doctrine.dbal.default_connection');

        $this->redisRepository = self::$container->get(RedisRepository::class);
        $this->gameMessageHandler = self::$container->get(GameMessageHandler::class);
    }

    protected function tearDown(): void
    {
        $this->entityManager->executeStatement('DELETE FROM messenger_messages');

        self::$container->get(RedisService::class)->deleteAll();

        $this->entityManager->close();
        $this->entityManager = null;

        parent::tearDown();
    }

    public function testGamesWithNoUserTips()
    {
        $gameMessageHandler = $this->gameMessageHandler;

        $matchListDataProvider = new MatchListDataProvider();
        $matchListDataProvider->fromArray(\Safe\json_decode(file_get_contents(__DIR__ . '/match.json'), true));

        $gameMessageHandler($matchListDataProvider);

        $messageInfo = $this->getMessageInfo();

        self::assertCount(1, $messageInfo);

        $message = $messageInfo[0];

        self::assertSame('calculation.to.app', $message['queue_name']);

        $body = \Safe\json_decode($message['body'], true);

        $ratingEventDataProvider = new RatingEventDataProvider();
        $ratingEventDataProvider->fromArray($body['data']);

        self::assertCount(0, $ratingEventDataProvider->getUsers());

        $this->checkGames($ratingEventDataProvider);
    }

    public function testGamesWithUserTips()
    {
        $this->saveUserTips();
        $gameMessageHandler = $this->gameMessageHandler;

        $matchListDataProvider = new MatchListDataProvider();
        $matchListDataProvider->fromArray(\Safe\json_decode(file_get_contents(__DIR__ . '/match.json'), true));

        $gameMessageHandler($matchListDataProvider);

        $messageInfo = $this->getMessageInfo();

        self::assertCount(1, $messageInfo);

        $message = $messageInfo[0];

        self::assertSame('calculation.to.app', $message['queue_name']);

        $body = \Safe\json_decode($message['body'], true);

        $ratingEventDataProvider = new RatingEventDataProvider();
        $ratingEventDataProvider->fromArray($body['data']);

        $users = $ratingEventDataProvider->getUsers();
        self::assertCount(2, $users);

        $user = $users[0];

        self::assertSame('ninja', $user->getName());
        self::assertSame(6, $user->getScoreSum());
        self::assertSame(1, $user->getPosition());
        self::assertSame(0, $user->getSumTeam());
        self::assertSame(1, $user->getSumScoreDiff());
        self::assertSame(1, $user->getSumWinExact());

        self::assertCount(5, $user->getTips());

        $tip = $user->getTips()[0];
        self::assertSame('2021-06-13:1500:EN-HR', $tip->getMatchId());
        self::assertSame('EN', $tip->getTeam1());
        self::assertSame('HR', $tip->getTeam2());
        self::assertSame(1, $tip->getScoreTeam1());
        self::assertSame(0, $tip->getScoreTeam2());
        self::assertSame(1, $tip->getTipTeam1());
        self::assertSame(0, $tip->getTipTeam2());
        self::assertSame(4, $tip->getScore());

        $tip = $user->getTips()[4];
        self::assertSame('2021-06-23:2100:PT-FR', $tip->getMatchId());
        self::assertNull($tip->getScoreTeam1());
        self::assertNull($tip->getScoreTeam2());
        self::assertSame(null, $tip->getTipTeam1());
        self::assertSame(null, $tip->getTipTeam2());
        self::assertSame(0, $tip->getScore());

        $user = $users[1];

        self::assertSame('rockstar', $user->getName());
        self::assertSame(0, $user->getScoreSum());
        self::assertSame(2, $user->getPosition());
        self::assertSame(0, $user->getSumTeam());
        self::assertSame(0, $user->getSumScoreDiff());
        self::assertSame(0, $user->getSumWinExact());

        self::assertCount(5, $user->getTips());

        $tip = $user->getTips()[0];
        self::assertSame('2021-06-13:1500:EN-HR', $tip->getMatchId());
        self::assertSame(1, $tip->getScoreTeam1());
        self::assertSame(0, $tip->getScoreTeam2());
        self::assertSame(null, $tip->getTipTeam1());
        self::assertSame(null, $tip->getTipTeam2());
        self::assertSame(0, $tip->getScore());

        $tip = $user->getTips()[4];
        self::assertSame('2021-06-23:2100:PT-FR', $tip->getMatchId());
        self::assertNull($tip->getScoreTeam1());
        self::assertNull($tip->getScoreTeam2());
        self::assertSame(1, $tip->getTipTeam1());
        self::assertSame(5, $tip->getTipTeam2());

        $this->checkGames($ratingEventDataProvider);
    }

    private function getMessageInfo(): array
    {
        $sql = "SELECT * FROM messenger_messages";
        $stmt = $this->entityManager->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }

    /**
     * @param \App\DataTransferObject\RatingEventDataProvider $ratingEventDataProvider
     */
    private function checkGames(RatingEventDataProvider $ratingEventDataProvider): void
    {
        $games = $ratingEventDataProvider->getGames();
        self::assertCount(5, $games);

        $game = $games[0];
        self::assertSame('2021-06-13:1500:EN-HR', $game->getMatchId());
        self::assertSame('EN', $game->getTeam1());
        self::assertSame('HR', $game->getTeam2());
        self::assertSame(1, $game->getScoreTeam1());
        self::assertSame(0, $game->getScoreTeam2());

        $game = $games[1];
        self::assertSame('2021-06-13:2100:NL-UA', $game->getMatchId());

        $game = $games[4];
        self::assertSame('2021-06-23:2100:PT-FR', $game->getMatchId());
        self::assertSame('PT', $game->getTeam1());
        self::assertSame('FR', $game->getTeam2());
        self::assertNull($game->getScoreTeam1());
        self::assertNull($game->getScoreTeam2());
    }

    private function saveUserTips()
    {
        $tipListDataProvider = new TippListDataProvider();
        $tipListDataProvider->fromArray([
            'data' => [
                [
                    'matchId' => '2021-06-13:1500:EN-HR',
                    'user' => 'ninja',
                    'tipTeam1' => 1,
                    'tipTeam2' => 0,
                ],
                [
                    'matchId' => '2021-06-13:2100:NL-UA',
                    'user' => 'ninja',
                    'tipTeam1' => 2,
                    'tipTeam2' => 1,
                ],
                [
                    'matchId' => '2021-06-15:1800:HU-PT',
                    'user' => 'ninja',
                    'tipTeam1' => 0,
                    'tipTeam2' => 4,
                ],
            ],
        ]);

        $this->redisRepository->saveUserTips('ninja', $tipListDataProvider);

        $tipListDataProvider2 = new TippListDataProvider();
        $tipListDataProvider2->fromArray([
            'data' => [
                [
                    'matchId' => '2021-06-23:2100:PT-FR',
                    'user' => 'rockstar',
                    'tipTeam1' => 1,
                    'tipTeam2' => 5,
                ],
            ],
        ]);

        $this->redisRepository->saveUserTips('rockstar', $tipListDataProvider2);
    }
}

