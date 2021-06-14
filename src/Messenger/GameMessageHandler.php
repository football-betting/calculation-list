<?php declare(strict_types=1);

namespace App\Messenger;

use App\Calculation\CalculationList;
use App\DataTransferObject\MatchListDataProvider;
use App\Redis\RedisRepository;

class GameMessageHandler
{
    private RedisRepository $redisRepository;

    /**
     * @var \App\Calculation\CalculationList
     */
    private CalculationList $calculationList;

    /**
     * @param \App\Redis\RedisRepository $redisRepository
     * @param \App\Calculation\CalculationList $calculationList
     */
    public function __construct(RedisRepository $redisRepository, CalculationList $calculationList)
    {
        $this->redisRepository = $redisRepository;
        $this->calculationList = $calculationList;
    }

    public function __invoke(MatchListDataProvider $matchListDataProvider)
    {
        $this->redisRepository->saveGames($matchListDataProvider);
        $this->calculationList->calculate();
    }
}
