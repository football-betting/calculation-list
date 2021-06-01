<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DataTransferObject\MatchDataProvider;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Persistence\CalculationListConfig;
use App\Service\CalculationListService;
use PHPUnit\Framework\TestCase;

class CalculationListServiceTest extends TestCase
{
    /**
     * @var CalculationListService
     */
    private $calc;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calc = new CalculationListService();
    }

    /**
     * @param $matchList
     * @param $tipList
     * @param $expectedOutCome
     * @dataProvider calculationListDataProvider
     */
    public function testCalculationListService($matchList, $tipList, $expectedOutCome)
    {
        $matchListDto = new MatchListDataProvider();
        $matches = [];
        foreach ($matchList['data'] as $match) {
            $matchDto = new MatchDataProvider();
            $matchDto->fromArray($match);
            $matches[] = $matchDto;
        }
        $matchListDto->setData($matches);
        $matchListDto->setEvent($matchList['event']);


        $tips = [];
        $tipListDto = new TippListDataProvider();
        foreach ($tipList['data'] as $tip) {
            $tipDto = new TippDataProvider();
            $tipDto->fromArray($tip);
            $tips[] = $tipDto;
        }
        $tipListDto->setData($tips);
        $tipListDto->setEvent($tipList['event']);

        $return = $this->calc->calculateList($matchListDto, $tipListDto);
        $this->assertSame($expectedOutCome['event'], $return->getEvent());

        foreach($return->getData() as $index => $calc) {
            $this->assertSame($expectedOutCome['data'][$index], $calc->toArray());
        }
    }

    public function calculationListDataProvider()
    {
        return [
            [
                //MatchList
                [
                    'event' => CalculationListConfig::MATCH_LIST_EVENT_NAME,
                    'data' => [
                        [
                            'matchId' => "2020-06-16:2100:FR-DE",
                            'team1' => 'FR',
                            'team2' => 'DE',
                            'matchDatetime' => '2020-06-16 21:00',
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4
                        ],
                        [
                            'matchId' => '2020-06-20:1800:PT-DE',
                            'team1' => 'PT',
                            'team2' => 'DE',
                            'matchDatetime' => '2020-06-20 18:00',
                            'scoreTeam1' => null,
                            'scoreTeam2' => null
                        ],
                        [
                            'matchId' => '2020-06-22:1800:PT-FR',
                            'team1' => 'PT',
                            'team2' => 'DE',
                            'matchDatetime' => '2020-06-22 18:00',
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 4
                        ],
                        [
                            'matchId' => '2020-06-25:1800:MA-DE',
                            'team1' => 'PT',
                            'team2' => 'DE',
                            'matchDatetime' => '2020-06-25 18:00',
                            'scoreTeam1' => 1,
                            'scoreTeam2' => 0
                        ]
                    ],
                ],
                //TipList
                [
                    'event' => CalculationListConfig::TIP_LIST_EVENT_NAME,
                    'data' => [
                        [
                            'matchId' => '2020-06-16:2100:FR-DE',
                            'user' => 'ninja',
                            'tipDatetime' => '2020-06-12 14:36',
                            'tipTeam1' => 2,
                            'tipTeam2' => 3
                        ],
                        [
                            'matchId' => '2020-06-25:1800:MA-DE',
                            'user' => 'ninja',
                            'tipDatetime' => '2020-06-12 14:36',
                            'tipTeam1' => 2,
                            'tipTeam2' => 1
                        ],
                        [
                            'matchId' => '2020-06-20:1800:PT-DE',
                            'user' => 'ninja',
                            'tipDatetime' => '2020-06-12 14:38',
                            'tipTeam1' => 0,
                            'tipTeam2' => 4
                        ],
                        [
                            'matchId' => '2020-06-22:1800:PT-FR',
                            'user' => 'robo',
                            'tipDatetime' => '2020-06-12 14:38',
                            'tipTeam1' => null,
                            'tipTeam2' => null
                        ],
                        [
                            'matchId' => '2020-06-16:2100:FR-DE',
                            'user' => 'robo',
                            'tipDatetime' => '2020-06-12 14:38',
                            'tipTeam1' => 1,
                            'tipTeam2' => 4
                        ]
                    ],
                ],
                //CalcList
                [
                    'event' => 'calculation',
                    'data' => [
                        [
                            'matchId' => '2020-06-16:2100:FR-DE',
                            'user' => 'ninja',
                            'score' => 1,
                            'tipTeam1' => 2,
                            'tipTeam2' => 3
                        ],
                        [
                            'matchId' => '2020-06-16:2100:FR-DE',
                            'user' => 'robo',
                            'score' => 4,
                            'tipTeam1' => 1,
                            'tipTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-20:1800:PT-DE',
                            'user' => 'ninja',
                            'score' => 0,
                            'tipTeam1' => 0,
                            'tipTeam2' => 4,
                        ],
                        [
                            'matchId' => '2020-06-22:1800:PT-FR',
                            'user' => 'robo',
                            'score' => 0,
                        ],
                        [
                            'matchId' => '2020-06-25:1800:MA-DE',
                            'user' => 'ninja',
                            'score' => 2,
                            'tipTeam1' => 2,
                            'tipTeam2' => 1
                        ],
                    ],
                ],
            ]
        ];
    }
}
