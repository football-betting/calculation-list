<?php declare(strict_types=1);

namespace App\Calculation\Position;

use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\UserRatingDataProvider;

class Position
{
    public function point(RatingEventDataProvider $ratingEventDataProvider): RatingEventDataProvider
    {
        $userRatingDataProviderList = $ratingEventDataProvider->getUsers();

        usort($userRatingDataProviderList, function (UserRatingDataProvider $a, UserRatingDataProvider $b) {
            return ($a->getScoreSum() <=> $b->getScoreSum()) * -1;
        });

        $position = 0;
        $lastPoint = -1;
        $positionForFrontend = 0;

        foreach ($userRatingDataProviderList as $userRatingDataProvider) {
            ++$position;
            if ($userRatingDataProvider->getScoreSum() !== $lastPoint) {
                $positionForFrontend = $position;
            }

            $userRatingDataProvider->setPosition($positionForFrontend);

            $lastPoint = $userRatingDataProvider->getScoreSum();
        }

        $ratingEventDataProvider->setUsers($userRatingDataProviderList);

        return $ratingEventDataProvider;
    }
}
