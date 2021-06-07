<?php declare(strict_types=1);

namespace App\Calculation\Score\Points;


use App\DataTransferObject\ResultDataProvider as Result;
use App\CalculationListConfig;

class WinScoreDiff implements ScoreInterface
{
    public function check(Result $result): bool
    {
        $check = false;
        if ($this->checkUserTipped($result)) {
            $diffUserResult = $result->getTipTeam1() - $result->getTipTeam2();
            $diffGameResult = $result->getScoreTeam1() - $result->getScoreTeam2();
            $check = ($diffGameResult === $diffUserResult);
        }

        return $check;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return CalculationListConfig::WIN_SCORE_DIFF;
    }

    /**
     * @param Result $result
     * @return bool
     */
    private function checkUserTipped(Result $result): bool
    {
        return $result->getTipTeam1() !== null && $result->getTipTeam2() !== null && $result->getScoreTeam1() !== null && $result->getScoreTeam2() !== null;
    }

}
