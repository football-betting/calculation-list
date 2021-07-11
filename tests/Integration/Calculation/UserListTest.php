<?php declare(strict_types=1);

namespace App\Tests\Integration\Calculation;

use App\Calculation\MatchPoint\MatchPointList;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Redis\RedisRepository;
use App\Redis\RedisService;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserListTest extends KernelTestCase
{
    private ?MatchPointList $userList;
    private ?Connection $entityManager;

    private ?RedisRepository $redisRepository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->entityManager = self::$container
            ->get('doctrine.dbal.default_connection');

        $this->redisRepository = self::$container->get(RedisRepository::class);
        $this->userList = self::$container->get(MatchPointList::class);
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
        $matchListDataProvider = $this->saveDemoData();
        $calculation = $this->userList->calculate($matchListDataProvider);

        $tips = $calculation->getData();
        self::assertCount(10, $tips);

        self::assertSame('2020-06-16:2100:FR-DE',$tips[1]->getMatchId());
        self::assertSame('rockstar',$tips[1]->getUser());
        self::assertSame(0,$tips[1]->getScore());
        self::assertSame(null,$tips[1]->getTipTeam1());
        self::assertSame(null,$tips[1]->getTipTeam2());
        self::assertSame(1,$tips[1]->getScoreTeam1());
        self::assertSame(4,$tips[1]->getScoreTeam2());
        self::assertSame('FR',$tips[1]->getTeam1());
        self::assertSame('DE',$tips[1]->getTeam2());

        self::assertSame('2020-06-16:2100:FR-DE',$tips[0]->getMatchId());
        self::assertSame('ninja',$tips[0]->getUser());
        self::assertSame(4,$tips[0]->getScore());
        self::assertSame(1,$tips[0]->getTipTeam1());
        self::assertSame(4,$tips[0]->getTipTeam2());
        self::assertSame(1,$tips[0]->getScoreTeam1());
        self::assertSame(4,$tips[0]->getScoreTeam2());
        self::assertSame('FR',$tips[0]->getTeam1());
        self::assertSame('DE',$tips[0]->getTeam2());

        self::assertSame('2020-06-20:1800:PT-DE',$tips[3]->getMatchId());
        self::assertSame('rockstar',$tips[3]->getUser());
        self::assertSame(0,$tips[3]->getScore());
        self::assertSame(0,$tips[3]->getTipTeam1());
        self::assertSame(0,$tips[3]->getTipTeam2());
        self::assertSame(null,$tips[3]->getScoreTeam1());
        self::assertSame(null,$tips[3]->getScoreTeam2());

        self::assertSame('2020-06-20:1800:PT-DE',$tips[2]->getMatchId());
        self::assertSame('ninja',$tips[2]->getUser());
        self::assertSame(0,$tips[2]->getScore());
        self::assertSame(2,$tips[2]->getTipTeam1());
        self::assertSame(1,$tips[2]->getTipTeam2());
        self::assertSame(null,$tips[2]->getScoreTeam1());
        self::assertSame(null,$tips[2]->getScoreTeam2());

        self::assertSame('2020-06-22:1800:PT-FR',$tips[5]->getMatchId());
        self::assertSame('rockstar',$tips[5]->getUser());
        self::assertSame(0,$tips[5]->getScore());
        self::assertSame(2,$tips[5]->getTipTeam1());
        self::assertSame(1,$tips[5]->getTipTeam2());
        self::assertSame(1,$tips[5]->getScoreTeam1());
        self::assertSame(4,$tips[5]->getScoreTeam2());

        self::assertSame('2020-06-22:1800:PT-FR',$tips[4]->getMatchId());
        self::assertSame('ninja',$tips[4]->getUser());
        self::assertSame(2,$tips[4]->getScore());
        self::assertSame(0,$tips[4]->getTipTeam1());
        self::assertSame(3,$tips[4]->getTipTeam2());
        self::assertSame(1,$tips[4]->getScoreTeam1());
        self::assertSame(4,$tips[4]->getScoreTeam2());

        self::assertSame('2020-06-24:1800:PL-RU',$tips[7]->getMatchId());
        self::assertSame('rockstar',$tips[7]->getUser());
        self::assertSame(1,$tips[7]->getScore());
        self::assertSame(2,$tips[7]->getTipTeam1());
        self::assertSame(0,$tips[7]->getTipTeam2());
        self::assertSame(1,$tips[7]->getScoreTeam1());
        self::assertSame(0,$tips[7]->getScoreTeam2());

        self::assertSame('2020-06-24:1800:PL-RU',$tips[6]->getMatchId());
        self::assertSame('ninja',$tips[6]->getUser());
        self::assertSame(0,$tips[6]->getScore());
        self::assertSame(null,$tips[6]->getTipTeam1());
        self::assertSame(null,$tips[6]->getTipTeam2());
        self::assertSame(1,$tips[6]->getScoreTeam1());
        self::assertSame(0,$tips[6]->getScoreTeam2());

        self::assertSame('2020-06-25:1800:MA-DE',$tips[9]->getMatchId());
        self::assertSame('rockstar',$tips[9]->getUser());
        self::assertSame(0,$tips[9]->getScore());
        self::assertSame(null,$tips[9]->getTipTeam1());
        self::assertSame(null,$tips[9]->getTipTeam2());
        self::assertSame(null,$tips[9]->getScoreTeam1());
        self::assertSame(null,$tips[9]->getScoreTeam2());
        self::assertSame('MA',$tips[9]->getTeam1());
        self::assertSame('DE',$tips[9]->getTeam2());

        self::assertSame('2020-06-25:1800:MA-DE',$tips[8]->getMatchId());
        self::assertSame('ninja',$tips[8]->getUser());
        self::assertSame(0,$tips[8]->getScore());
        self::assertSame(null,$tips[8]->getTipTeam1());
        self::assertSame(null,$tips[8]->getTipTeam2());
        self::assertSame(null,$tips[8]->getScoreTeam1());
        self::assertSame(null,$tips[8]->getScoreTeam2());
        self::assertSame('MA',$tips[8]->getTeam1());
        self::assertSame('DE',$tips[8]->getTeam2());


    }

    private function getMessageInfo(): array
    {
        $sql = "SELECT * FROM messenger_messages";
        $stmt = $this->entityManager->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }

    /**
     * @return \App\DataTransferObject\MatchListDataProvider
     */
    private function saveDemoData(): MatchListDataProvider
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
                    'matchId' => '2020-06-24:1800:PL-RU',
                    'team1' => 'PL',
                    'team2' => 'RU',
                    'matchDatetime' => '2020-06-22 18:00',
                    'scoreTeam1' => 1,
                    'scoreTeam2' => 0,
                ],
                [
                    'matchId' => '2020-06-25:1800:MA-DE',
                    'team1' => 'MA',
                    'team2' => 'DE',
                    'matchDatetime' => '2020-06-25 18:00',
                    'scoreTeam1' => null,
                    'scoreTeam2' => null,
                ],
            ],
        ]);

        $this->redisRepository->saveGames($matchListDataProvider);

        $tipListDataProvider = new TippListDataProvider();
        $tipListDataProvider->fromArray([
            'data' => [
                [
                    'matchId' => '2020-06-16:2100:FR-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 1,
                    'tipTeam2' => 4
                ],
                [
                    'matchId' => '2020-06-20:1800:PT-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 2,
                    'tipTeam2' => 1
                ],
                [
                    'matchId' => '2020-06-22:1800:PT-FR',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:38',
                    'tipTeam1' => 0,
                    'tipTeam2' => 3
                ],
            ],
        ]);

        $this->redisRepository->saveUserTips('ninja', $tipListDataProvider);

        $tipListDataProvider = new TippListDataProvider();
        $tipListDataProvider->fromArray([
            'data' => [
                [
                    'matchId' => '2020-06-20:1800:PT-DE',
                    'user' => 'rockstar',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 0,
                    'tipTeam2' => 0
                ],
                [
                    'matchId' => '2020-06-22:1800:PT-FR',
                    'user' => 'rockstar',
                    'tipDatetime' => '2020-06-12 14:38',
                    'tipTeam1' => 2,
                    'tipTeam2' => 1
                ],
                [
                    'matchId' => '2020-06-24:1800:PL-RU',
                    'user' => 'rockstar',
                    'tipDatetime' => '2020-06-12 14:38',
                    'tipTeam1' => 2,
                    'tipTeam2' => 0
                ],
            ],
        ]);

        $this->redisRepository->saveUserTips('rockstar', $tipListDataProvider);

        return $matchListDataProvider;
    }
}
