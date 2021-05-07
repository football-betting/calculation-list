<?php declare(strict_types=1);

namespace App\Service;

class CalculationListService
{
    public function calculateList($matchList, $tippList)
    {
        $calculationList = [];
        dump($matchList);
        dump($tippList);
        die(PHP_EOL . '<br>die: ' . __FUNCTION__ .' / '. __FILE__ .' / '. __LINE__);

        return $calculationList;
    }
}