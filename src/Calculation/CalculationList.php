<?php declare(strict_types=1);

namespace App\Calculation;

use App\Calculation\MatchPoint\MatchPointList;
use App\Calculation\Rating\PointsSum;
use App\Redis\RedisRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class CalculationList
{
    private RedisRepository $redisRepository;
    /**
     * @var \Symfony\Component\Messenger\MessageBusInterface
     */
    private MessageBusInterface $messageBus;
    /**
     * @var \App\Calculation\MatchPoint\MatchPointList
     */
    private MatchPointList $matchPointList;
    /**
     * @var \App\Calculation\Rating\PointsSum
     */
    private PointsSum $pointsSum;

    public function __construct(
        RedisRepository $redisRepository,
        MatchPointList $matchPointList,
        MessageBusInterface $messageBus,
        PointsSum $pointsSum
    )
    {
        $this->redisRepository = $redisRepository;
        $this->messageBus = $messageBus;
        $this->matchPointList = $matchPointList;
        $this->pointsSum = $pointsSum;
    }

    public function calculate()
    {
        $games = $this->redisRepository->getGames();
        $calculationListDataProvider = $this->matchPointList->calculate($games);

        $ratingEventDataProvider = $this->pointsSum->get($calculationListDataProvider);

    }
}
