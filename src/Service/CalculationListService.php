<?php declare(strict_types=1);

namespace App\Service;

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

    public function calculateList($matchList, $tippList)
    {
        $calculationList = [];
        dump($matchList);
        dump($tippList);
        die(PHP_EOL . '<br>die: ' . __FUNCTION__ .' / '. __FILE__ .' / '. __LINE__);
        $score = $this->calcService->calculatePoints($result);

        return $calculationList;
    }
}