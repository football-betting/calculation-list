<?php declare(strict_types=1);

namespace App\Calculation;

use App\Calculation\MatchPoint\MatchPointList;
use App\Calculation\Position\Position;
use App\Calculation\Rating\PointsSum;
use App\Calculation\Sorting\Games;
use App\Calculation\Sorting\UserTips;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
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
    /**
     * @var \App\Calculation\Position\Position
     */
    private Position $position;
    /**
     * @var \App\Calculation\Sorting\Games
     */
    private Games $games;
    /**
     * @var \App\Calculation\Sorting\UserTips
     */
    private UserTips $userTips;

    public function __construct(
        RedisRepository $redisRepository,
        MatchPointList $matchPointList,
        MessageBusInterface $messageBus,
        PointsSum $pointsSum,
        Position $position,
        Games $games,
        UserTips $userTips
    )
    {
        $this->redisRepository = $redisRepository;
        $this->messageBus = $messageBus;
        $this->matchPointList = $matchPointList;
        $this->pointsSum = $pointsSum;

        $this->position = $position;
        $this->games = $games;
        $this->userTips = $userTips;
    }

    public function calculate()
    {
        $games = $this->redisRepository->getGames();
        $fullRatingTables = $this->getRatingDataProviderByGames($games);

        $this->messageBus->dispatch($fullRatingTables);
    }

    /**
     * @param \App\DataTransferObject\MatchListDataProvider $games
     *
     * @return \App\DataTransferObject\RatingEventDataProvider
     */
    private function getRatingDataProviderByGames(MatchListDataProvider $games): RatingEventDataProvider
    {
        $calculationListDataProvider = $this->matchPointList->calculate($games);

        $ratingEventDataProvider = $this->pointsSum->get($calculationListDataProvider);
        $ratingEventDataProvider = $this->position->point($ratingEventDataProvider);

        $ratingEventDataProvider->setGames($games->getData());

        $ratingEventDataProvider = $this->games->sort($ratingEventDataProvider);

        $this->userTips->sort($ratingEventDataProvider);
        return $ratingEventDataProvider;
    }
}
