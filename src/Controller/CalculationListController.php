<?php declare(strict_types=1);

namespace App\Controller;

class CalculationListController
{

    /**
     * @param $matchList
     * @param $tippList
     */
    public function calculateList($matchList, $tippList)
    {
        $calcService = new \CalculationListService();

        $calcService->calculateList($matchList, $tippList);
    }
}