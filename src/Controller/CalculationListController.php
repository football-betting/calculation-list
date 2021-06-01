<?php declare(strict_types=1);

namespace App\Controller;

use App\Business\CacheListFacade;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Persistence\CalculationListConfig;
use App\Service\CalculationListService;

class CalculationListController
{
    /** @var CalculationListService */
    private $calcService;

    /**
     * @var CacheListFacade
     */
    private $cacheListFacade;

    public function __construct()
    {
        $this->calcService = new CalculationListService();
        $this->cacheListFacade = new CacheListFacade();
    }

    public function calculateList()
    {
        $matchList = $this->cacheListFacade->getList(CalculationListConfig::MATCH_LIST_NAME)
            ?? (new MatchListDataProvider())->setEvent(CalculationListConfig::MATCH_LIST_EVENT_NAME);
        $tipList =  $this->cacheListFacade->getList(CalculationListConfig::TIP_LIST_NAME)
            ?? (new TippListDataProvider())->setEvent(CalculationListConfig::TIP_LIST_EVENT_NAME);

        $calList = $this->calcService->calculateList(
            json_decode($matchList),
            json_decode($tipList)
        );

        $this->saveList(
            CalculationListConfig::CALC_LIST_NAME,
            json_encode($calList, true)
        );
    }

    /**
     * @param string $listName
     * @param string $list
     */
    public function saveList(string $listName, string $list): void
    {
        $this->cacheListFacade->saveList($listName, $list);
    }

    /**
     * @param string $listName
     * @return string
     */
    public function getList(string $listName): string
    {
        return $this->cacheListFacade->getList($listName);
    }
}