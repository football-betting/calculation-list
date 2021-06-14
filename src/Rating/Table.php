<?php declare(strict_types=1);

namespace App\Rating;

use App\DataTransferObject\CalculationListDataProvider;

class Table
{
    public function get(CalculationListDataProvider $calculationListDataProvider)
    {
        $data = $calculationListDataProvider->getData();

    }
}
