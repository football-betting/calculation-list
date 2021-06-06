<?php declare(strict_types=1);

namespace App\Calculation\Score\Points;


use App\DataTransferObject\ResultDataProvider as Result;
use App\Persistence\CalculationListConfig;

class NoWin implements ScoreInterface
{
    public function check(Result $result): bool
    {
        return true;
    }

    public function getScore(): int
    {
        return CalculationListConfig::NO_WIN_TEAM;
    }

}
