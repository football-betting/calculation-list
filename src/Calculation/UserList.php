<?php declare(strict_types=1);

namespace App\Calculation;

use App\Calculation\Score\CalculationScore;
use App\Redis\RedisRepository;

class UserList
{
    private CalculationScore $calculationScore;

    private RedisRepository $redisRepository;

    /**
     * @param \App\Calculation\Score\CalculationScore $calculationScore
     */
    public function __construct(CalculationScore $calculationScore, RedisRepository $redisRepository)
    {
        $this->calculationScore = $calculationScore;
        $this->redisRepository = $redisRepository;
    }

    public function calculate()
    {
        $userTips = $this->redisRepository->getUsersTips();
        $games = $this->redisRepository->getGames();

        
    }


}
