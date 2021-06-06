<?php declare(strict_types=1);

namespace App\Calculation\Score;

use App\Calculation\Score\Points\ScoreInterface;
use App\DataTransferObject\ResultDataProvider;

final class CalculationScore
{
    /**
     * @var \App\Calculation\Score\Points\ScoreInterface[] $scoreCollections
     */
    private array $scoreCollections;

    /**
     * @param \App\Calculation\Score\Points\ScoreInterface ...$scoreCollections
     */
    public function __construct(ScoreInterface...$scoreCollections)
    {
        usort($scoreCollections, function ($a, $b) {
            return -($a->getScore() <=> $b->getScore());
        });

        $this->scoreCollections = $scoreCollections;
    }

    /**
     * @param ResultDataProvider $result
     *
     * @return int
     */
    public function calculatePoints(ResultDataProvider $result): int
    {
        $calculatedPoints = 0;

        foreach ($this->scoreCollections as $collection) {
            if ($collection->check($result) === true) {
                $calculatedPoints = $collection->getScore();
                break;
            }
        }

        return $calculatedPoints;
    }
}
