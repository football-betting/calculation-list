<?php declare(strict_types=1);

namespace App\Calculation\Rating;

use App\CalculationListConfig;
use App\DataTransferObject\CalculationListDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\UserRatingDataProvider;

class PointsSum
{
    public function get(CalculationListDataProvider $calculationListDataProvider): RatingEventDataProvider
    {
        $calculationDataProviderList = $calculationListDataProvider->getData();

        $userToTips = [];

        foreach ($calculationDataProviderList as $calculationDataProvider) {
            $userToTips[$calculationDataProvider->getUser()][] = $calculationDataProvider;
        }

        $ratingEventDataProvider = new RatingEventDataProvider();
        /** @var \App\DataTransferObject\CalculationDataProvider[] $userCalculationDataProviderList */
        foreach ($userToTips as $userName => $userCalculationDataProviderList) {
            $userRatingDataProvider = new UserRatingDataProvider();
            $userRatingDataProvider->setName($userName);

            $scoreSum = 0;
            $sumWinExact = 0;
            $sumScoreDiff = 0;
            $sumTeam = 0;

            foreach ($userCalculationDataProviderList as $userCalculationDataProvider) {
                $userRatingDataProvider->addTip($userCalculationDataProvider);
                $score = $userCalculationDataProvider->getScore();
                $scoreSum += $score;

                if ($score === CalculationListConfig::WIN_EXACT) {
                    ++$sumWinExact;
                } elseif ($score === CalculationListConfig::WIN_SCORE_DIFF) {
                    ++$sumScoreDiff;
                } elseif ($score === CalculationListConfig::WIN_TEAM) {
                    ++$sumTeam;
                }
            }

            $userRatingDataProvider->setScoreSum($scoreSum);
            $userRatingDataProvider->setSumScoreDiff($sumScoreDiff);
            $userRatingDataProvider->setSumTeam($sumTeam);
            $userRatingDataProvider->setSumWinExact($sumWinExact);

            $ratingEventDataProvider->addUser($userRatingDataProvider);
        }

        return $ratingEventDataProvider;
    }

    /**
     * @param string $date
     *
     * @throws \Exception
     * @return int
     */
    private function formatDate(string $date): int
    {
        return (int)(new \DateTime($date))->format('YmdHi');
    }
}
