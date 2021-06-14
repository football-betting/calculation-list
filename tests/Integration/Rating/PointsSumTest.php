<?php declare(strict_types=1);

namespace App\Tests\Integration\Rating;

use App\DataTransferObject\CalculationListDataProvider;
use App\Rating\PointsSum;
use PHPUnit\Framework\TestCase;

class PointsSumTest extends TestCase
{
    public function test()
    {
        $calculationListDataProvider = $this->getData();
        $table = new PointsSum();
        $userEvent = $table->get($calculationListDataProvider);

        $users = $userEvent->getUsers();

        self::assertCount(3, $users);

        self::assertSame('johndoe', $users[0]->getName());
        self::assertSame(5, $users[0]->getScoreSum());
        self::assertSame(1, $users[0]->getSumWinExact());
        self::assertSame(0, $users[0]->getSumScoreDiff());
        self::assertSame(1, $users[0]->getSumTeam());
        self::assertCount(2, $users[0]->getTips());

        self::assertSame('rockstar', $users[1]->getName());
        self::assertSame(1, $users[1]->getScoreSum());
        self::assertSame(0, $users[1]->getSumWinExact());
        self::assertSame(0, $users[1]->getSumScoreDiff());
        self::assertSame(1, $users[1]->getSumTeam());
        self::assertCount(5, $users[1]->getTips());

        self::assertSame('ninja', $users[2]->getName());
        self::assertSame(6, $users[2]->getScoreSum());
        self::assertSame(1, $users[2]->getSumWinExact());
        self::assertSame(1, $users[2]->getSumScoreDiff());
        self::assertSame(0, $users[2]->getSumTeam());
        self::assertCount(5, $users[2]->getTips());
    }

    public function getData()
    {
        $calculationListDataProvider = new CalculationListDataProvider();
        $calculationListDataProvider->fromArray(
            [
                'data' =>
                    [
                        [
                            'matchId' => '2020-06-22:1800:PT-FR',
                            'user' => 'johndoe',
                            'score' => 4,
                            'tipTeam1' => 1,
                            'tipTeam2' => 4,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-24:1800:PL-RU',
                            'user' => 'johndoe',
                            'score' => 1,
                            'tipTeam1' => 2,
                            'tipTeam2' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 0,
                        ],
                        [
                            'matchId' => '2020-06-16:2100:FR-DE',
                            'user' => 'rockstar',
                            'score' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-16:2100:FR-DE',
                            'user' => 'ninja',
                            'score' => 4,
                            'tipTeam1' => 1,
                            'tipTeam2' => 4,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-20:1800:PT-DE',
                            'user' => 'rockstar',
                            'score' => 0,
                            'tipTeam1' => 0,
                            'tipTeam2' => 0,
                        ],
                        [
                            'matchId' => '2020-06-20:1800:PT-DE',
                            'user' => 'ninja',
                            'score' => 0,
                            'tipTeam1' => 2,
                            'tipTeam2' => 1,
                        ],
                        [
                            'matchId' => '2020-06-22:1800:PT-FR',
                            'user' => 'rockstar',
                            'score' => 0,
                            'tipTeam1' => 2,
                            'tipTeam2' => 1,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-22:1800:PT-FR',
                            'user' => 'ninja',
                            'score' => 2,
                            'tipTeam1' => 0,
                            'tipTeam2' => 3,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-24:1800:PL-RU',
                            'user' => 'rockstar',
                            'score' => 1,
                            'tipTeam1' => 2,
                            'tipTeam2' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 0,
                        ],
                        [
                            'matchId' => '2020-06-24:1800:PL-RU',
                            'user' => 'ninja',
                            'score' => 0,
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 0,
                        ],
                        [
                            'matchId' => '2020-06-25:1800:MA-DE',
                            'user' => 'rockstar',
                            'score' => 0,
                        ],
                        [
                            'matchId' => '2020-06-25:1800:MA-DE',
                            'user' => 'ninja',
                            'score' => 0,
                        ],
                    ],
            ]
        );

        return $calculationListDataProvider;
    }
}
