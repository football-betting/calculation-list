<?php declare(strict_types=1);

namespace App\Calculation\Sorting;

use App\DataTransferObject\MatchDataProvider;
use App\DataTransferObject\RatingEventDataProvider;

class Games
{
    public function sort(RatingEventDataProvider $ratingEventDataProvider)
    {
        $games = $ratingEventDataProvider->getGames();

        usort($games, function (MatchDataProvider $a, MatchDataProvider $b) {

            $matchIdOne = substr($a->getMatchId(), 0, -6);
            $matchIdOne = str_replace(':' , ' ', $matchIdOne);
            $matchIdOne = (int)(new \DateTime($matchIdOne))->format('YmdHi');

            $matchIdTwo = substr($b->getMatchId(), 0, -6);
            $matchIdTwo = str_replace(':' , ' ', $matchIdTwo);
            $matchIdTwo = (int)(new \DateTime($matchIdTwo))->format('YmdHi');

            return ($matchIdOne <=> $matchIdTwo);
        });

        $ratingEventDataProvider->setGames($games);

        return $ratingEventDataProvider;
    }
}
