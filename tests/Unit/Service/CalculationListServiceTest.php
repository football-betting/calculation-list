<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DataTransferObject\MatchDataProvider;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippDataProvider;
use App\DataTransferObject\TippListDataProvider;
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
     * @dataProvider calculationListDataProvider
     */
    public function testCalculationListService($matchList, $tippList, $expectedOutCome)
    {
        $matchListDto = new MatchListDataProvider();
        $matches = [];
        foreach($matchList['data'] as $match){
            $matchDto = new MatchDataProvider();
            $matchDto->fromArray($match);
            $matches[] = $matchDto;
        }
        $matchListDto->setData($matches);
        $matchListDto->setEvent($matchList['event']);


        $tipps = [];
        $tippListDto = new TippListDataProvider();
        foreach($tippList['data'] as $tipp){
            $tippDto = new TippDataProvider();
            $tippDto->fromArray($tipp);
            $tipps[] = $tippDto;
        }
        $tippListDto->setData($tipps);
        $tippListDto->setEvent($tippList['event']);

        $return = $this->calc->calculateList($matchListDto, $tippListDto);
    }

    public function calculationListDataProvider()
    {
        return [
            [
                //MatchList
                [
                    'event' => 'match',
                    'data'  => [
                        [
                            'matchId'       => "2020-06-16:21:FR-DE",
                            'team1'         => 'FR',
                            'team2'         => 'DE',
                            'matchDatetime' => '2020-06-16 21:00',
                            'scoreTeam1'    => 1,
                            'scoreTeam2'    => 4
                        ],
                        [
                            'matchId'       => '2020-06-20:1800-PT-DE',
                            'team1'         => 'PT',
                            'team2'         => 'DE',
                            'matchDatetime' => '2020-06-20 18:00',
                            'scoreTeam1'    => null,
                            'scoreTeam2'    => null
                        ]
                    ],

                ],
                //TippList
                [
                    'event' => 'tip.userlist',
                    'data'  => [
                        [
                            'matchId'     => '2020-06-16:2100-FR-DE',
                            'user'        => 'ninja',
                            'tipDatetime' => '2020-06-12 14:36',
                            'tipTeam1'    => 2,
                            'tipTeam2'    => 3
                        ],
                        [
                            'matchId'     => '2020-06-16:2100-PL-IT',
                            'user'        => 'ninja',
                            'tipDatetime' => '2020-06-12 14:38',
                            'tipTeam1'    => 0,
                            'tipTeam2'    => 4
                        ]
                    ],
                ],
                //CalcList
                [],
            ]
        ];
    }
}
