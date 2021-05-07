<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DataTransferObject\ResultDataProvider;
use App\Persistence\CalculationListConfig;
use App\Service\CalculationService;
use App\Service\Score\NoWin;
use App\Service\Score\WinExact;
use App\Service\Score\WinScoreDiff;
use App\Service\Score\WinTeam;
use RuntimeException;
use PHPUnit\Framework\TestCase;

class CalculationServiceTest extends TestCase
{
    /**
     * @param $firstTeamResult
     * @param $secondTeamResult
     * @param $firstTeamUserResult
     * @param $secondTeamUserResult
     * @param $expectedScore
     * @dataProvider calculationPointsDataProvider
     */
    public function testCalculatePoints(
        $firstTeamResult,
        $secondTeamResult,
        $firstTeamUserResult,
        $secondTeamUserResult,
        $expectedScore
    ) {
        $calc = new CalculationService(
            new WinExact(),
            new WinTeam(),
            new NoWin(),
            new WinScoreDiff()
        );

        $result = new ResultDataProvider();
        $result->setScoreTeam1($firstTeamResult);
        $result->setScoreTeam2($secondTeamResult);
        $result->setTipTeam1($firstTeamUserResult);
        $result->setTipTeam2($secondTeamUserResult);

        $return = $calc->calculatePoints($result);

        $this->assertSame($expectedScore, $return);
    }

    public function testException()
    {
        $this->expectException(RuntimeException::class);
        $calc = new CalculationService(
            new \stdClass,
            new \stdClass
        );

        $result = new ResultDataProvider(1, 1, 1, 1);
        $calc->calculatePoints($result);
    }

    /**
     * @return array
     */
    public function calculationPointsDataProvider(): array
    {
        return [
            [1, 2, 1, 2, CalculationListConfig::WIN_EXACT],
            // NO_WIN_TEAM
            [2, 1, 0, 1, CalculationListConfig::NO_WIN_TEAM],
            [1, 3, 3, 2, CalculationListConfig::NO_WIN_TEAM],
            [0, 0, 2, 0, CalculationListConfig::NO_WIN_TEAM],
            [0, 1, 0, 0, CalculationListConfig::NO_WIN_TEAM],

            [0, 1, null, null, CalculationListConfig::NO_WIN_TEAM],
            [0, 0, null, null, CalculationListConfig::NO_WIN_TEAM],
            [1, 0, null, null, CalculationListConfig::NO_WIN_TEAM],

            // WIN_EXACT
            [1, 2, 1, 2, CalculationListConfig::WIN_EXACT],
            [2, 1, 2, 1, CalculationListConfig::WIN_EXACT],
            [2, 0, 2, 0, CalculationListConfig::WIN_EXACT],
            [0, 2, 0, 2, CalculationListConfig::WIN_EXACT],
            [2, 2, 2, 2, CalculationListConfig::WIN_EXACT],

            // WIN_SCORE_DIFF
            [1, 3, 2, 4, CalculationListConfig::WIN_SCORE_DIFF],
            [4, 2, 3, 1, CalculationListConfig::WIN_SCORE_DIFF],
            [1, 0, 2, 1, CalculationListConfig::WIN_SCORE_DIFF],
            [1, 2, 0, 1, CalculationListConfig::WIN_SCORE_DIFF],
            [3, 3, 0, 0, CalculationListConfig::WIN_SCORE_DIFF],
            [3, 3, 4, 4, CalculationListConfig::WIN_SCORE_DIFF],

            // WIN_TEAM
            [1, 3, 1, 2, CalculationListConfig::WIN_TEAM],
            [2, 1, 3, 1, CalculationListConfig::WIN_TEAM],
            [1, 0, 2, 0, CalculationListConfig::WIN_TEAM],
            [0, 5, 0, 2, CalculationListConfig::WIN_TEAM],
            [2, 3, 2, 5, CalculationListConfig::WIN_TEAM],
        ];
    }
}
