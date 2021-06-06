<?php declare(strict_types=1);

namespace App\Calculation;

use App\Calculation\Score\CalculationScore;

class UserList
{
    private CalculationScore $calculationScore;

    /**
     * @param \App\Calculation\Score\CalculationScore $calculationScore
     */
    public function __construct(CalculationScore $calculationScore)
    {
        $this->calculationScore = $calculationScore;
    }


}
