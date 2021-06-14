<?php declare(strict_types=1);

namespace App\Tests\Unit\Calculation\Position;

use App\Calculation\Position\Position;
use App\DataTransferObject\RatingEventDataProvider;
use App\DataTransferObject\UserRatingDataProvider;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    /**
     * @dataProvider getData
     */
    public function testPostion(array $data, array $expected)
    {
        $position = new Position();

        $ratingEventDataProvider = new RatingEventDataProvider();

        foreach ($data as $user => $score) {
            $userRatingDataProvider = new UserRatingDataProvider();
            $userRatingDataProvider->setScoreSum($score);
            $userRatingDataProvider->setName($user);

            $ratingEventDataProvider->addUser($userRatingDataProvider);
        }

        $ratingEventDataProvider = $position->point($ratingEventDataProvider);
        $checkUser = $ratingEventDataProvider->getUsers();

        self::assertCount(count($expected), $checkUser);

        foreach ($expected as $key => $info) {
            self::assertSame($info['name'], $checkUser[$key]->getName(), 'Name is not correct. Shoud be ' . $info['name'] . ' is: ' . $checkUser[$key]->getName());
            self::assertSame($info['position'], $checkUser[$key]->getPosition(), 'Position is not correct. Shoud be ' . $info['position'] . ' is: ' . $checkUser[$key]->getPosition() );
        }
    }

    public function getData()
    {
        return [
            [
                'data' => [
                    'jahnedoe' => 2,
                    'ninja' => 5,
                    'babo' => 10,
                    'abdul' => 9,
                    'rockstar' => 5,
                    'theBest' => 8,
                    'johndoe' => 9,
                ],
                'expected' => [
                    [
                        'position' => 1,
                        'name' => 'babo',
                    ],
                    [
                        'position' => 2,
                        'name' => 'abdul',
                    ],
                    [
                        'position' => 2,
                        'name' => 'johndoe',
                    ],
                    [
                        'position' => 4,
                        'name' => 'theBest',
                    ],
                    [
                        'position' => 5,
                        'name' => 'ninja',
                    ],
                    [
                        'position' => 5,
                        'name' => 'rockstar',
                    ],
                    [
                        'position' => 7,
                        'name' => 'jahnedoe',
                    ],
                ],
            ],
            [
                'data' => [
                    'jahnedoe' => 8,
                    'ninja' => 10,
                    'babo' => 10,
                    'abdul' => 9,
                    'rockstar' => 5,
                    'theBest' => 5,
                    'johndoe' => 9,
                ],
                'expected' => [
                    [
                        'position' => 1,
                        'name' => 'ninja',
                    ],
                    [
                        'position' => 1,
                        'name' => 'babo',
                    ],
                    [
                        'position' => 3,
                        'name' => 'abdul',
                    ],
                    [
                        'position' => 3,
                        'name' => 'johndoe',
                    ],
                    [
                        'position' => 5,
                        'name' => 'jahnedoe',
                    ],
                    [
                        'position' => 6,
                        'name' => 'rockstar',
                    ],
                    [
                        'position' => 6,
                        'name' => 'theBest',
                    ],
                ],
            ],
        ];
    }
}
