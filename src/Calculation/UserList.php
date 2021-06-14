<?php declare(strict_types=1);

namespace App\Calculation;

use App\Calculation\Score\CalculationScore;
use App\CalculationListConfig;
use App\DataTransferObject\CalculationDataProvider;
use App\DataTransferObject\CalculationListDataProvider;
use App\DataTransferObject\ResultDataProvider;
use App\Redis\RedisRepository;
use Symfony\Component\Messenger\MessageBusInterface;

class UserList
{
    private CalculationScore $calculationScore;

    private RedisRepository $redisRepository;
    /**
     * @var \Symfony\Component\Messenger\MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * @param \App\Calculation\Score\CalculationScore $calculationScore
     */
    public function __construct(
        CalculationScore $calculationScore,
        RedisRepository $redisRepository,
        MessageBusInterface $messageBus
    )
    {
        $this->calculationScore = $calculationScore;
        $this->redisRepository = $redisRepository;
        $this->messageBus = $messageBus;
    }

    public function calculate(): CalculationListDataProvider
    {
        $userTips = $this->redisRepository->getUsersTips();

        $userToUserTips = [];
        foreach ($userTips as $tippListDataProvider) {
            foreach ($tippListDataProvider->getData() as $data) {
                $userToUserTips[$data->getUser()][$data->getMatchId()] = $data;
            }
        }

        $games = $this->redisRepository->getGames();

        $calculationList = new CalculationListDataProvider();

        foreach ($games->getData() as $game) {
            foreach ($userToUserTips as $userName => $userMatchList) {
                $calculationDataProvider = new CalculationDataProvider();
                $calculationDataProvider->setMatchId($game->getMatchId());
                $calculationDataProvider->setUser($userName);

                $calculationDataProvider->setScoreTeam1($game->getScoreTeam1());
                $calculationDataProvider->setScoreTeam2($game->getScoreTeam2());

                $score = CalculationListConfig::NO_WIN_TEAM;

                if (isset($userMatchList[$game->getMatchId()])) {
                    $userTip = $userMatchList[$game->getMatchId()];

                    $calculationDataProvider->setTipTeam1($userTip->getTipTeam1());
                    $calculationDataProvider->setTipTeam2($userTip->getTipTeam2());

                    if ($game->getScoreTeam1() !== null && $game->getScoreTeam2() !== null && $userTip->getTipTeam1() !== null && $userTip->getTipTeam2() !== null) {
                        //@toDo i dont need ResultDataProvider, just $calculationDataProvider -> refactor this
                        $result = new ResultDataProvider();
                        $result->setScoreTeam1($game->getScoreTeam1());
                        $result->setScoreTeam2($game->getScoreTeam2());
                        $result->setTipTeam1($userTip->getTipTeam1());
                        $result->setTipTeam2($userTip->getTipTeam2());

                        $score = $this->calculationScore->calculatePoints($result);
                    }
                }

                $calculationDataProvider->setScore($score);

                $calculationList->addData($calculationDataProvider);
            }
        }

        return $calculationList;
//        $this->messageBus->dispatch($calculationList);
    }
}
