<?php declare(strict_types=1);

namespace App\Tests\Unit\Calculation\Rating;

use App\Calculation\Rating\Winners;
use App\DataTransferObject\MatchDataProvider;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\UserRatingDataProvider;
use PHPUnit\Framework\TestCase;

class WinnersTest extends TestCase
{
    public function testWhenItWin()
    {
        $games = $this->getGames();
        $games->getData()[1]->setScoreTeam1(2);
        $games->getData()[1]->setScoreTeam2(1);

        $ratingEventDataProvider = $this->getRating();

        $ratingEventDataProvider = (new Winners())->get($ratingEventDataProvider, $games);

        $users = $ratingEventDataProvider->getUsers();

        self::assertSame('wesoly', $users[0]->getName());
        self::assertSame(2, $users[0]->getScoreSum());
        self::assertSame(0, $users[0]->getExtraPoint());

        self::assertSame('Schnils', $users[1]->getName());
        self::assertSame(17, $users[1]->getScoreSum());
        self::assertSame(7, $users[1]->getExtraPoint());

        self::assertSame('Lech', $users[2]->getName());
        self::assertSame(12, $users[2]->getScoreSum());
        self::assertSame(7, $users[2]->getExtraPoint());

        self::assertSame('michel.k81@web.de', $users[3]->getName());
        self::assertSame(16, $users[3]->getScoreSum());
        self::assertSame(15, $users[3]->getExtraPoint());

        self::assertSame('Jegocz', $users[4]->getName());
        self::assertSame(3, $users[4]->getScoreSum());
        self::assertSame(0, $users[4]->getExtraPoint());
    }

    public function testWhenEnWin()
    {
        $games = $this->getGames();
        $games->getData()[1]->setScoreTeam1(0);
        $games->getData()[1]->setScoreTeam2(1);

        $ratingEventDataProvider = $this->getRating();

        $ratingEventDataProvider = (new Winners())->get($ratingEventDataProvider, $games);

        $users = $ratingEventDataProvider->getUsers();

        self::assertSame('wesoly', $users[0]->getName());
        self::assertSame(9, $users[0]->getScoreSum());
        self::assertSame(7, $users[0]->getExtraPoint());

        self::assertSame('Schnils', $users[1]->getName());
        self::assertSame(10, $users[1]->getScoreSum());
        self::assertSame(0, $users[1]->getExtraPoint());

        self::assertSame('Lech', $users[2]->getName());
        self::assertSame(20, $users[2]->getScoreSum());
        self::assertSame(15, $users[2]->getExtraPoint());

        self::assertSame('michel.k81@web.de', $users[3]->getName());
        self::assertSame(8, $users[3]->getScoreSum());
        self::assertSame(7, $users[3]->getExtraPoint());

        self::assertSame('Jegocz', $users[4]->getName());
        self::assertSame(3, $users[4]->getScoreSum());
        self::assertSame(0, $users[4]->getExtraPoint());
    }

    public function testWhenNoWin()
    {
        $games = $this->getGames();
        $games->getData()[1]->setScoreTeam1(0);
        $games->getData()[1]->setScoreTeam2(0);

        $ratingEventDataProvider = $this->getRating();

        $ratingEventDataProvider = (new Winners())->get($ratingEventDataProvider, $games);

        $users = $ratingEventDataProvider->getUsers();

        self::assertSame('wesoly', $users[0]->getName());
        self::assertSame(2, $users[0]->getScoreSum());
        self::assertSame(0, $users[0]->getExtraPoint());

        self::assertSame('Schnils', $users[1]->getName());
        self::assertSame(10, $users[1]->getScoreSum());
        self::assertSame(0, $users[1]->getExtraPoint());

        self::assertSame('Lech', $users[2]->getName());
        self::assertSame(5, $users[2]->getScoreSum());
        self::assertSame(0, $users[2]->getExtraPoint());

        self::assertSame('michel.k81@web.de', $users[3]->getName());
        self::assertSame(1, $users[3]->getScoreSum());
        self::assertSame(0, $users[3]->getExtraPoint());

        self::assertSame('Jegocz', $users[4]->getName());
        self::assertSame(3, $users[4]->getScoreSum());
        self::assertSame(0, $users[4]->getExtraPoint());
    }

    public function testBoforeFinalStart()
    {
        $games = $this->getGames();
        $games->getData()[1]->setScoreTeam1(null);
        $games->getData()[1]->setScoreTeam2(null);

        $ratingEventDataProvider = $this->getRating();

        $ratingEventDataProvider = (new Winners())->get($ratingEventDataProvider, $games);

        $users = $ratingEventDataProvider->getUsers();


        self::assertSame('wesoly', $users[0]->getName());
        self::assertSame(2, $users[0]->getScoreSum());
        self::assertSame(0, $users[0]->getExtraPoint());

        self::assertSame('Schnils', $users[1]->getName());
        self::assertSame(10, $users[1]->getScoreSum());
        self::assertSame(0, $users[1]->getExtraPoint());

        self::assertSame('Lech', $users[2]->getName());
        self::assertSame(5, $users[2]->getScoreSum());
        self::assertSame(0, $users[2]->getExtraPoint());

        self::assertSame('michel.k81@web.de', $users[3]->getName());
        self::assertSame(1, $users[3]->getScoreSum());
        self::assertSame(0, $users[3]->getExtraPoint());

        self::assertSame('Jegocz', $users[4]->getName());
        self::assertSame(3, $users[4]->getScoreSum());
        self::assertSame(0, $users[4]->getExtraPoint());
    }

    private function getGames(): MatchListDataProvider
    {
        $matchListDataProvider = new MatchListDataProvider();

        $matchDataProvider = new MatchDataProvider();
        $matchDataProvider->setMatchId('2020-06-20:1900:PT-DE');
        $matchDataProvider->setScoreTeam1(1);
        $matchDataProvider->setScoreTeam2(2);

        $matchListDataProvider->addData($matchDataProvider);

        $matchDataProvider = new MatchDataProvider();
        $matchDataProvider->setMatchId('2021-07-11:2100:IT-EN');

        $matchListDataProvider->addData($matchDataProvider);

        $matchDataProvider = new MatchDataProvider();
        $matchDataProvider->setMatchId('2020-06-20:1900:EN-DE');
        $matchDataProvider->setScoreTeam1(2);
        $matchDataProvider->setScoreTeam2(1);

        $matchListDataProvider->addData($matchDataProvider);

        return $matchListDataProvider;
    }

    /**
     * @return \App\DataTransferObject\RatingEventDataProvider
     */
    private function getRating(): RatingEventDataProvider
    {
        $ratingEventDataProvider = new RatingEventDataProvider();

        $userRatingDataProvider = new UserRatingDataProvider();
        $userRatingDataProvider->setName('wesoly');
        $userRatingDataProvider->setScoreSum(2);
        $userRatingDataProvider->setExtraPoint(0);

        $ratingEventDataProvider->addUser($userRatingDataProvider);

        $userRatingDataProvider = new UserRatingDataProvider();
        $userRatingDataProvider->setName('Schnils');
        $userRatingDataProvider->setScoreSum(10);
        $userRatingDataProvider->setExtraPoint(0);

        $ratingEventDataProvider->addUser($userRatingDataProvider);

        $userRatingDataProvider = new UserRatingDataProvider();
        $userRatingDataProvider->setName('Lech');
        $userRatingDataProvider->setScoreSum(5);
        $userRatingDataProvider->setExtraPoint(0);

        $ratingEventDataProvider->addUser($userRatingDataProvider);

        $userRatingDataProvider = new UserRatingDataProvider();
        $userRatingDataProvider->setName('michel.k81@web.de');
        $userRatingDataProvider->setScoreSum(1);
        $userRatingDataProvider->setExtraPoint(0);

        $ratingEventDataProvider->addUser($userRatingDataProvider);

        $userRatingDataProvider = new UserRatingDataProvider();
        $userRatingDataProvider->setName('Jegocz');
        $userRatingDataProvider->setScoreSum(3);
        $userRatingDataProvider->setExtraPoint(0);

        $ratingEventDataProvider->addUser($userRatingDataProvider);
        return $ratingEventDataProvider;
    }
}

