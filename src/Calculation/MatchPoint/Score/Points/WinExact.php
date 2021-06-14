<?php declare(strict_types=1);

namespace App\Calculation\MatchPoint\Score\Points;


use App\DataTransferObject\ResultDataProvider as Result;
use App\CalculationListConfig;

class WinExact implements ScoreInterface
{
    public function check(Result $result): bool
    {
        return $this->checkScore1EqualToTipp($result)
        && $this->checkScore2EqualToTipp($result);
    }

    public function getScore(): int
    {
        return CalculationListConfig::WIN_EXACT;
    }

    /**
     * @param Result $result
     * @return bool
     */
    private function checkScore1EqualToTipp(Result $result): bool
    {
        return $result->getScoreTeam1() === $result->getTipTeam1();
    }

    /**
     * @param Result $result
     * @return bool
     */
    private function checkScore2EqualToTipp(Result $result): bool
    {
        return $result->getScoreTeam2() === $result->getTipTeam2();
    }

}
