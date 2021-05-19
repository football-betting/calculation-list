<?php declare(strict_types=1);

namespace App\Controller;

use App\Business\CacheListFacade;
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

    /**
     * @param $matchList
     * @param $tippList
     */
    public function calculateList()
    {
        $matchList = $this->cacheListFacade->getList(CalculationListConfig::MATCH_LIST_NAME);
        $tippList =  $this->cacheListFacade->getList(CalculationListConfig::TIPP_LIST_NAME);


        $this->calcService->calculateList($matchList, $tippList);
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