<?php declare(strict_types=1);

namespace App\Service;

use App\DataTransferObject\CalculationDataProvider;
use App\DataTransferObject\CalculationListDataProvider;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\ResultDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Persistence\CalculationListConfig;
use App\Service\Score\NoWin;
use App\Service\Score\WinExact;
use App\Service\Score\WinScoreDiff;
use App\Service\Score\WinTeam;

class CalculationListService
{
    /** @var CalculationService */
    private $calcService;

    public function __construct()
    {
        $this->calcService = new CalculationService(
            new WinExact(),
            new WinTeam(),
            new NoWin(),
            new WinScoreDiff()
        );
    }

    /**
     * @param MatchListDataProvider $matchList
     * @param TippListDataProvider $tipList
     * @return array
     */
    public function calculateList(MatchListDataProvider $matchList, TippListDataProvider $tipList): CalculationListDataProvider
    {
        $calculationList = new CalculationListDataProvider();
        $calculationList->setEvent(CalculationListConfig::CALC_LIST_EVENT_NAME);

        foreach($matchList->getData() as $match)
        {
            foreach($tipList->getData() as $userTip)
            {
                if($match->getMatchId() === $userTip->getMatchId()) {
                    $calc = new CalculationDataProvider();
                    $result = new ResultDataProvider();

                    $result->setScoreTeam1($match->getScoreTeam1());
                    $result->setScoreTeam2($match->getScoreTeam2());
                    $result->setTipTeam1($userTip->getTipTeam1());
                    $result->setTipTeam2($userTip->getTipTeam2());

                    $calc->setMatchId($match->getMatchId());
                    $calc->setTipTeam1($userTip->getTipTeam1());
                    $calc->setTipTeam2($userTip->getTipTeam2());
                    $calc->setScore($this->calcService->calculatePoints($result));
                    $calc->setUser($userTip->getUser());


                    $data = $calculationList->getData();
                    $data[] = $calc;
                    $calculationList->setData($data);
                }
            }
        }

        return $calculationList;
    }
}