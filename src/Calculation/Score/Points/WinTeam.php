<?php declare(strict_types=1);

namespace App\Calculation\Score\Points;

use App\DataTransferObject\ResultDataProvider as Result;
use App\CalculationListConfig;

class WinTeam implements ScoreInterface
{
    public function check(Result $result): bool
    {
        $check = false;
        if ($this->checkActuallyScoreNotEqual($result)
            && $this->checkTippScoreNotEqual($result)
        ) {
            $firstTeamWins = $result->getScoreTeam1() > $result->getScoreTeam2();
            $tippFirstTeamWins = $result->getTipTeam1() > $result->getTipTeam2();
            $check = $firstTeamWins === $tippFirstTeamWins;
        }

        return $check;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return CalculationListConfig::WIN_TEAM;
    }

    /**
     * @param Result $result
     * @return bool
     */
    private function checkActuallyScoreNotEqual(Result $result): bool
    {
        return $result->getScoreTeam1() != $result->getScoreTeam2();
    }

    /**
     * @param Result $result
     * @return bool
     */
    private function checkTippScoreNotEqual(Result $result): bool
    {
        return $result->getTipTeam1() != $result->getTipTeam2();
    }

}
