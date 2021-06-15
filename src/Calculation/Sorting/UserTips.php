<?php declare(strict_types=1);

namespace App\Calculation\Sorting;

use App\DataTransferObject\CalculationDataProvider;
use App\DataTransferObject\RatingEventDataProvider;

class UserTips
{
    public function sort(RatingEventDataProvider $ratingEventDataProvider)
    {
        $users = $ratingEventDataProvider->getUsers();

        foreach ($users as $user) {
            $tips = $user->getTips();
            usort($tips, function (CalculationDataProvider $a, CalculationDataProvider $b) {

                $matchIdOne = substr($a->getMatchId(), 0, -6);
                $matchIdOne = str_replace(':' , ' ', $matchIdOne);
                $matchIdOne = (int)(new \DateTime($matchIdOne))->format('YmdHi');

                $matchIdTwo = substr($b->getMatchId(), 0, -6);
                $matchIdTwo = str_replace(':' , ' ', $matchIdTwo);
                $matchIdTwo = (int)(new \DateTime($matchIdTwo))->format('YmdHi');

                return ($matchIdOne <=> $matchIdTwo);
            });

            $user->setTips($tips);
        }

        return $ratingEventDataProvider;
    }
}
