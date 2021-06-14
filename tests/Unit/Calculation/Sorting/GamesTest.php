<?php declare(strict_types=1);

namespace App\Tests\Unit\Calculation\Sorting;

use App\Calculation\Sorting\Games;
use App\DataTransferObject\MatchDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
use PHPUnit\Framework\TestCase;

class GamesTest extends TestCase
{
    public function test()
    {
        $games = new Games();

        $ratingEventDataProvider = new RatingEventDataProvider();
        $matchIdList = [
            '2020-06-20:1900:PT-DE',
            '2020-06-16:2100:FR-DE',
            '2020-06-16:2100:IT-EN',
            '2020-06-22:2100:RU-SK',
            '2020-06-24:1800:PL-RU',
            '2020-06-16:1800:PL-EN',
            '2020-06-20:1800:PT-DE',
            '2020-06-25:1800:MA-DE',
            '2020-06-22:1800:PT-FR',
        ];

        foreach ($matchIdList as $matchId) {
            $matchDataProvider = new MatchDataProvider();
            $matchDataProvider->setMatchId($matchId);

            $ratingEventDataProvider->addGame($matchDataProvider);
        }

        $ratingEventDataProvider = $games->sort($ratingEventDataProvider);

        $checkGames = $ratingEventDataProvider->getGames();

        self::assertCount(count($matchIdList), $checkGames);

        self::assertSame('2020-06-16:1800:PL-EN',$checkGames[0]->getMatchId());
        self::assertSame('2020-06-16:2100:FR-DE',$checkGames[1]->getMatchId());
        self::assertSame('2020-06-16:2100:IT-EN',$checkGames[2]->getMatchId());
        self::assertSame('2020-06-20:1800:PT-DE',$checkGames[3]->getMatchId());
        self::assertSame('2020-06-20:1900:PT-DE',$checkGames[4]->getMatchId());
        self::assertSame('2020-06-22:1800:PT-FR',$checkGames[5]->getMatchId());
        self::assertSame('2020-06-22:2100:RU-SK',$checkGames[6]->getMatchId());
        self::assertSame('2020-06-24:1800:PL-RU',$checkGames[7]->getMatchId());
        self::assertSame('2020-06-25:1800:MA-DE',$checkGames[8]->getMatchId());

    }
}
