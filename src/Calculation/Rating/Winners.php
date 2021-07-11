<?php declare(strict_types=1);

namespace App\Calculation\Rating;

use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\RatingEventDataProvider;

class Winners
{
    public function get(RatingEventDataProvider $ratingEventDataProvider, MatchListDataProvider $games): RatingEventDataProvider
    {
        $winner = $this->getWinner($games);

        if ($winner !== '') {
            $userWinners = json_decode(file_get_contents(__DIR__ . '/winners.json'), true);
            $user2Winners = [];
            foreach ($userWinners as $userWinner) {
                $user2Winners[$userWinner['username']] = $userWinner;
            }

            $users = $ratingEventDataProvider->getUsers();

            foreach ($users as $user) {
                if (isset($user2Winners[$user->getName()])) {
                    $user2win = $user2Winners[$user->getName()];

                    $user->setExtraPoint(0);
                    if (
                        $user2win['tip1'] === $winner) {
                        $user->setExtraPoint(15);
                    }

                    if ($user2win['tip2'] === $winner) {
                        $user->setExtraPoint(7);
                    }

                    $user->setScoreSum(
                        $user->getScoreSum() + $user->getExtraPoint()
                    );
                }
            }
        }

        return $ratingEventDataProvider;
    }

    private function getWinner(MatchListDataProvider $games): string
    {
        return 'IT';
        $finalMatchId = '2021-07-11:2100:IT-EN';
        $winner = '';
        foreach ($games->getData() as $game) {
            if ($game->getMatchId() === $finalMatchId) {
                if ($game->getScoreTeam1() > 0 || $game->getScoreTeam2() > 0) {
                    if ($game->getScoreTeam1() > $game->getScoreTeam2()) {
                        $winner = 'IT';
                    }

                    if ($game->getScoreTeam1() < $game->getScoreTeam2()) {
                        $winner = 'EN';
                    }

                }

                break;
            }
        }

        return $winner;
    }
}
