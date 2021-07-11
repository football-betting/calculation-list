<?php declare(strict_types=1);

namespace App\Tests\Integration\Redis;

use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Redis\RedisRepository;
use App\Redis\RedisService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RedisRepositoryTest extends KernelTestCase
{
    private ?RedisRepository $redisRepository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();

        $this->redisRepository = self::$container->get(RedisRepository::class);
    }

    protected function tearDown(): void
    {
        self::$container->get(RedisService::class)->deleteAll();
        parent::tearDown();
    }

    public function testSaveAndGetGames()
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

        $matchListDataProviderRedis = $this->redisRepository->getGames();

        self::assertCount(count($matchListDataProvider->getData()), $matchListDataProviderRedis->getData());

        $expectedMatchListDataProvider = $matchListDataProvider->getData();
        foreach ($matchListDataProviderRedis->getData() as $key => $matchDataProviderRedis) {

            $expectedMatchDataProvider = $expectedMatchListDataProvider[$key];
            self::assertSame($expectedMatchDataProvider->getMatchId(), $matchDataProviderRedis->getMatchId());
            self::assertSame($expectedMatchDataProvider->getScoreTeam1(), $matchDataProviderRedis->getScoreTeam1());
            self::assertSame($expectedMatchDataProvider->getScoreTeam2(), $matchDataProviderRedis->getScoreTeam2());
            self::assertSame($expectedMatchDataProvider->getTeam1(), $matchDataProviderRedis->getTeam1());
            self::assertSame($expectedMatchDataProvider->getTeam2(), $matchDataProviderRedis->getTeam2());
        }
    }

    public function testSaveAndGetUserTips()
    {
        $tipListDataProvider = new TippListDataProvider();
        $tipListDataProvider->fromArray([
            'data' => [
                [
                    'matchId' => '2020-06-16:2100:FR-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 2,
                    'tipTeam2' => 3,
                ],
                [
                    'matchId' => '2020-06-25:1800:MA-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 2,
                    'tipTeam2' => 1,
                ],
                [
                    'matchId' => '2020-06-20:1800:PT-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:38',
                    'tipTeam1' => 0,
                    'tipTeam2' => 4,
                ],
            ],
        ]);

        $this->redisRepository->saveUserTips('ninja', $tipListDataProvider);

        $userListDataProviderRedis = $this->redisRepository->getUsersTips();

        self::assertCount(1, $userListDataProviderRedis);
        self::assertCount(count($tipListDataProvider->getData()), $userListDataProviderRedis[0]->getData());

        $expectedMatchListDataProvider = $tipListDataProvider->getData();
        foreach ($userListDataProviderRedis[0]->getData() as $key => $matchDataProviderRedis) {

            $expectedMatchDataProvider = $expectedMatchListDataProvider[$key];
            self::assertSame($expectedMatchDataProvider->getMatchId(), $matchDataProviderRedis->getMatchId());
            self::assertSame($expectedMatchDataProvider->getUser(), $matchDataProviderRedis->getUser());
            self::assertSame($expectedMatchDataProvider->getTipTeam1(), $matchDataProviderRedis->getTipTeam1());
            self::assertSame($expectedMatchDataProvider->getTipDatetime(), $matchDataProviderRedis->getTipDatetime());
            self::assertSame($expectedMatchDataProvider->getTipTeam2(), $matchDataProviderRedis->getTipTeam2());
        }
    }

    public function testSaveAndGetUserTipsWhenTwoUserAreInRedis()
    {
        $tipListDataProvider = new TippListDataProvider();
        $tipListDataProvider->fromArray([
            'data' => [
                [
                    'matchId' => '2020-06-16:2100:FR-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 2,
                    'tipTeam2' => 3,
                ],
                [
                    'matchId' => '2020-06-25:1800:MA-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 2,
                    'tipTeam2' => 1,
                ],
                [
                    'matchId' => '2020-06-20:1800:PT-DE',
                    'user' => 'ninja',
                    'tipDatetime' => '2020-06-12 14:38',
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
                    'matchId' => '2020-06-16:2100:FR-DE',
                    'user' => 'rockstar',
                    'tipDatetime' => '2020-06-12 15:36',
                    'tipTeam1' => 1,
                    'tipTeam2' => 5,
                ],
                [
                    'matchId' => '2020-06-25:1800:PL-EN',
                    'user' => 'rockstar',
                    'tipDatetime' => '2020-06-12 14:36',
                    'tipTeam1' => 0,
                    'tipTeam2' => 2,
                ],
            ],
        ]);

        $this->redisRepository->saveUserTips('rockstar', $tipListDataProvider2);

        $userListDataProviderRedis = $this->redisRepository->getUsersTips();

        self::assertCount(2, $userListDataProviderRedis);
        self::assertCount(count($tipListDataProvider->getData()), $userListDataProviderRedis[0]->getData());
        self::assertCount(count($tipListDataProvider2->getData()), $userListDataProviderRedis[1]->getData());

        $expectedMatchListDataProvider = $tipListDataProvider->getData();
        foreach ($userListDataProviderRedis[0]->getData() as $key => $matchDataProviderRedis) {

            $expectedMatchDataProvider = $expectedMatchListDataProvider[$key];
            self::assertSame($expectedMatchDataProvider->getMatchId(), $matchDataProviderRedis->getMatchId());
            self::assertSame($expectedMatchDataProvider->getUser(), $matchDataProviderRedis->getUser());
            self::assertSame($expectedMatchDataProvider->getTipTeam1(), $matchDataProviderRedis->getTipTeam1());
            self::assertSame($expectedMatchDataProvider->getTipDatetime(), $matchDataProviderRedis->getTipDatetime());
            self::assertSame($expectedMatchDataProvider->getTipTeam2(), $matchDataProviderRedis->getTipTeam2());
        }

        $expectedMatchListDataProvider = $tipListDataProvider2->getData();
        foreach ($userListDataProviderRedis[1]->getData() as $key => $matchDataProviderRedis) {

            $expectedMatchDataProvider = $expectedMatchListDataProvider[$key];
            self::assertSame($expectedMatchDataProvider->getMatchId(), $matchDataProviderRedis->getMatchId());
            self::assertSame($expectedMatchDataProvider->getUser(), $matchDataProviderRedis->getUser());
            self::assertSame($expectedMatchDataProvider->getTipTeam1(), $matchDataProviderRedis->getTipTeam1());
            self::assertSame($expectedMatchDataProvider->getTipDatetime(), $matchDataProviderRedis->getTipDatetime());
            self::assertSame($expectedMatchDataProvider->getTipTeam2(), $matchDataProviderRedis->getTipTeam2());
        }
    }

    public function testGetUsersTipsWhenRedisHaveNoUser()
    {
        $userListDataProviderRedis = $this->redisRepository->getUsersTips();

        self::assertCount(0, $userListDataProviderRedis);
    }
}
