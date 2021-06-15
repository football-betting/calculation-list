<?php declare(strict_types=1);

namespace App\Tests\Acceptance\Messenger;

use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Messenger\GameMessageHandler;
use App\Messenger\UserTipMessageHandler;
use App\Redis\RedisRepository;
use App\Redis\RedisService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTipMessageHandlerTest extends KernelTestCase
{
    private ?object $entityManager;
    private ?RedisRepository $redisRepository;
    private ?UserTipMessageHandler $userTipMessageHandler;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->entityManager = self::$container
            ->get('doctrine.dbal.default_connection');

        $this->redisRepository = self::$container->get(RedisRepository::class);
        $this->userTipMessageHandler = self::$container->get(UserTipMessageHandler::class);
    }

    protected function tearDown(): void
    {
        $this->entityManager->executeStatement('DELETE FROM messenger_messages');

        self::$container->get(RedisService::class)->deleteAll();

        $this->entityManager->close();
        $this->entityManager = null;

        parent::tearDown();
    }

    public function test()
    {
        $this->saveGames();

        $tippListDataProvider = new TippListDataProvider();
        $tippListDataProvider->fromArray(json_decode(file_get_contents(__DIR__ . '/user.json'), true));

        $userTipMessageHandler = $this->userTipMessageHandler;
        $userTipMessageHandler($tippListDataProvider);

        $messageInfo = $this->getMessageInfo();

        //@toTo write good test

        self::assertCount(1, $messageInfo);
    }

    private function saveGames()
    {
        $matchListDataProvider = new MatchListDataProvider();
        $matchListDataProvider->fromArray([
            'data' => [
                [
                    'matchId' => "2020-06-16:2100:FR-DE",
                    'team1' => 'FR',
                    'team2' => 'DE',
                    'matchDatetime' => '2020-06-16 21:00',
                    'scoreTeam1' => 1,
                    'scoreTeam2' => 4,
                ],
                [
                    'matchId' => '2020-06-20:1800:PT-DE',
                    'team1' => 'PT',
                    'team2' => 'DE',
                    'matchDatetime' => '2020-06-20 18:00',
                    'scoreTeam1' => null,
                    'scoreTeam2' => null,
                ],
                [
                    'matchId' => '2020-06-22:1800:PT-FR',
                    'team1' => 'EN',
                    'team2' => 'DE',
                    'matchDatetime' => '2020-06-22 18:00',
                    'scoreTeam1' => 1,
                    'scoreTeam2' => 4,
                ],
                [
                    'matchId' => '2020-06-25:1800:MA-DE',
                    'team1' => 'PL',
                    'team2' => 'RU',
                    'matchDatetime' => '2020-06-25 18:00',
                    'scoreTeam1' => 1,
                    'scoreTeam2' => 0,
                ],
            ],
        ]);

        $this->redisRepository->saveGames($matchListDataProvider);
    }

    private function getMessageInfo(): array
    {
        $sql = "SELECT * FROM messenger_messages";
        $stmt = $this->entityManager->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }
}
