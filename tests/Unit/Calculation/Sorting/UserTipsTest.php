<?php declare(strict_types=1);

namespace App\Tests\Unit\Calculation\Sorting;

use App\Calculation\Sorting\UserTips;
use App\DataTransferObject\CalculationDataProvider;
use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\UserRatingDataProvider;
use PHPUnit\Framework\TestCase;

class UserTipsTest extends TestCase
{
    public function test()
    {
        $ratingEventDataProvider = new RatingEventDataProvider();

        $userData = self::DATA['userData'];
        foreach (self::DATA['userData'] as $userInfo) {
            $userRatingDataProvider = new UserRatingDataProvider();
            $userRatingDataProvider->setName($userInfo['user']);
            foreach ($userInfo['tips'] as $matchId) {
                $tip = new CalculationDataProvider();
                $tip->setMatchId($matchId);
                $userRatingDataProvider->addTip($tip);
            }
            $ratingEventDataProvider->addUser($userRatingDataProvider);
        }

        $userTipsSorting = new UserTips();
        $userTipsSorting->sort($ratingEventDataProvider);

        $users = $ratingEventDataProvider->getUsers();

        self::assertCount(2, $users);

        $user = $users[0];

        self::assertSame('ninja', $user->getName());

        $tips = $user->getTips();

        $expectedTips = self::DATA['expectedUsersMatchIds'][0];
        self::assertCount(count($expectedTips), $tips);

        foreach ($expectedTips as $key => $expectedMatchId) {
            self::assertSame($expectedMatchId, $tips[$key]->getMatchId());
        }

        $user = $users[1];

        self::assertSame('rockstar', $user->getName());

        $tips = $user->getTips();

        $expectedTips = self::DATA['expectedUsersMatchIds'][1];
        self::assertCount(count($expectedTips), $tips);

        foreach ($expectedTips as $key => $expectedMatchId) {
            self::assertSame($expectedMatchId, $tips[$key]->getMatchId());
        }
    }


    private const DATA =
        [
            'userData' =>
                [
                    [
                        'user' => 'ninja',
                        'tips' => [
                            '2020-06-20:1900:PT-DE',
                            '2020-06-16:2100:IT-EN',
                            '2020-06-16:2100:FR-DE',
                            '2020-06-22:2100:RU-SK',
                        ],
                    ],
                    [
                        'user' => 'rockstar',
                        'tips' => [
                            '2020-06-20:1900:PT-DE',
                            '2020-06-16:2100:FR-DE',
                            '2020-06-16:2100:IT-EN',
                            '2020-06-22:2100:RU-SK',
                            '2020-06-24:1800:PL-RU',
                            '2020-06-16:1800:PL-EN',
                            '2020-06-20:1800:PT-DE',
                            '2020-06-25:1800:MA-DE',
                            '2020-06-22:1800:PT-FR',
                        ],
                    ],
                ],
            'expectedUsersMatchIds' => [
                [
                    '2020-06-16:2100:FR-DE',
                    '2020-06-16:2100:IT-EN',
                    '2020-06-20:1900:PT-DE',
                    '2020-06-22:2100:RU-SK',
                ],
                [
                    '2020-06-16:1800:PL-EN',
                    '2020-06-16:2100:FR-DE',
                    '2020-06-16:2100:IT-EN',
                    '2020-06-20:1800:PT-DE',
                    '2020-06-20:1900:PT-DE',
                    '2020-06-22:1800:PT-FR',
                    '2020-06-22:2100:RU-SK',
                    '2020-06-24:1800:PL-RU',
                    '2020-06-25:1800:MA-DE',
                ],
            ],
        ];
}
