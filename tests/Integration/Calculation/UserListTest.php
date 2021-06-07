<?php declare(strict_types=1);

namespace App\Tests\Integration\Calculation;

use App\Calculation\UserList;
use App\DataTransferObject\CalculationListDataProvider;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Redis\RedisRepository;
use App\Redis\RedisService;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserListTest extends KernelTestCase
{
    private ?UserList $userList;
    private ?Connection $entityManager;

    private ?RedisRepository $redisRepository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->entityManager = self::$container
            ->get('doctrine.dbal.default_connection');

        $this->redisRepository = self::$container->get(RedisRepository::class);
        $this->userList = self::$container->get(UserList::class);
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
        $this->saveDemoData();
        $this->userList->calculate();

        $messageInfo = $this->getMessageInfo();

        self::assertCount(2, $messageInfo);

        $message = $messageInfo[0];
        $calculation = new CalculationListDataProvider();
        $calculation->fromArray(json_decode($message['body'], true));

        self::assertSame('calculation.to.ranking', $calculation->getEvent());

        $tips = $calculation->getData();
        self::assertCount(10, $tips);

        self::assertSame('2020-06-16:2100:FR-DE',$tips[0]->getMatchId());
        self::assertSame('rockstar',$tips[0]->getUser());
        self::assertSame(0,$tips[0]->getScore());
        self::assertSame(null,$tips[0]->getTipTeam1());
        self::assertSame(null,$tips[0]->getTipTeam2());


        self::assertSame('2020-06-16:2100:FR-DE',$tips[1]->getMatchId());
        self::assertSame('ninja',$tips[1]->getUser());
        self::assertSame(4,$tips[1]->getScore());
        self::assertSame(1,$tips[1]->getTipTeam1());
        self::assertSame(4,$tips[1]->getTipTeam2());

        self::assertSame('2020-06-20:1800:PT-DE',$tips[2]->getMatchId());
        self::assertSame('rockstar',$tips[2]->getUser());
        self::assertSame(0,$tips[2]->getScore());
        self::assertSame(null,$tips[2]->getTipTeam1());
        self::assertSame(null,$tips[2]->getTipTeam2());

        self::assertSame('2020-06-20:1800:PT-DE',$tips[3]->getMatchId());
        self::assertSame('ninja',$tips[3]->getUser());
        self::assertSame(0,$tips[3]->getScore());
        self::assertSame(null,$tips[3]->getTipTeam1());
        self::assertSame(null,$tips[3]->getTipTeam2());

        self::assertSame('2020-06-22:1800:PT-FR',$tips[4]->getMatchId());
        self::assertSame('rockstar',$tips[4]->getUser());
        self::assertSame(0,$tips[4]->getScore());
        self::assertSame(2,$tips[4]->getTipTeam1());
        self::assertSame(1,$tips[4]->getTipTeam2());

        self::assertSame('2020-06-22:1800:PT-FR',$tips[5]->getMatchId());
        self::assertSame('ninja',$tips[5]->getUser());
        self::assertSame(2,$tips[5]->getScore());
        self::assertSame(0,$tips[5]->getTipTeam1());
        self::assertSame(3,$tips[5]->getTipTeam2());

        self::assertSame('2020-06-24:1800:PL-RU',$tips[6]->getMatchId());
        self::assertSame('rockstar',$tips[6]->getUser());
        self::assertSame(1,$tips[6]->getScore());
        self::assertSame(2,$tips[6]->getTipTeam1());
        self::assertSame(0,$tips[6]->getTipTeam2());

        self::assertSame('2020-06-24:1800:PL-RU',$tips[7]->getMatchId());
        self::assertSame('ninja',$tips[7]->getUser());
        self::assertSame(0,$tips[7]->getScore());
        self::assertSame(null,$tips[7]->getTipTeam1());
        self::assertSame(null,$tips[7]->getTipTeam2());

        self::assertSame('2020-06-25:1800:MA-DE',$tips[8]->getMatchId());
        self::assertSame('rockstar',$tips[8]->getUser());
        self::assertSame(0,$tips[8]->getScore());
        self::assertSame(null,$tips[8]->getTipTeam1());
        self::assertSame(null,$tips[8]->getTipTeam2());

        self::assertSame('2020-06-25:1800:MA-DE',$tips[9]->getMatchId());
        self::assertSame('ninja',$tips[9]->getUser());
        self::assertSame(0,$tips[9]->getScore());
        self::assertSame(null,$tips[9]->getTipTeam1());
        self::assertSame(null,$tips[9]->getTipTeam2());

        self::assertSame(json_decode($messageInfo[0]['body'], true)['data'], json_decode($messageInfo[1]['body'], true)['data']);
    }

    private function getMessageInfo(): array
    {
        $sql = "SELECT * FROM messenger_messages";
        $stmt = $this->entityManager->prepare($sql);
        return $stmt->executeQuery()->fetchAllAssociative();
    }


    private function saveDemoData(): void
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
                    'team1' => 'PL',
                    'team2' => 'RU',
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
    }
}