<?php declare(strict_types=1);

namespace App\Calculation;

use App\Calculation\Score\CalculationScore;
use App\CalculationListConfig;
use App\DataTransferObject\CalculationDataProvider;
use App\DataTransferObject\CalculationListDataProvider;
use App\DataTransferObject\ResultDataProvider;
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

                $score = CalculationListConfig::NO_WIN_TEAM;

                if (isset($userMatchList[$game->getMatchId()]) && $game->getScoreTeam1() !== null && $game->getScoreTeam2() !== null) {
                    $userTip = $userMatchList[$game->getMatchId()];

                    $result = new ResultDataProvider();
                    $result->setScoreTeam1($game->getScoreTeam1());
                    $result->setScoreTeam2($game->getScoreTeam2());
                    $result->setTipTeam1($userTip->getTipTeam1());
                    $result->setTipTeam2($userTip->getTipTeam2());

                    $score = $this->calculationScore->calculatePoints($result);

                    $calculationDataProvider->setTipTeam1($userTip->getTipTeam1());
                    $calculationDataProvider->setTipTeam2($userTip->getTipTeam2());
                }

                $calculationDataProvider->setScore($score);

                $calculationList->addData($calculationDataProvider);
            }


        }

    }


}
