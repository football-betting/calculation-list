<?php declare(strict_types=1);

namespace App\Calculation\MatchPoint\Score\Points;

use App\DataTransferObject\ResultDataProvider as Result;

interface ScoreInterface
{
    /**
     * @param Result $result
     * @return bool
     */
    public function check(Result $result): bool;

    /**
     * @return int
     */
    public function getScore(): int;
}
