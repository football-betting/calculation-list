<?php declare(strict_types=1);

namespace App\Service;

use App\DataTransferObject\ResultDataProvider;
use App\Service\Score\ScoreInterface;

class CalculationService
{
    /**
     * @var ScoreInterface[] $scoreCollections
     */
    private $scoreCollections;

    /**
     * @param mixed ...$scoreCollections
     */
    public function __construct(...$scoreCollections)
    {
        $this->scoreCollections = $scoreCollections;
    }

    /**
     * @param ResultDataProvider $result
     * @return int
     */
    public function calculatePoints(ResultDataProvider $result): int
    {
        $calculatedPoints = 0;
        $this>$this->checkCollection();
        usort($this->scoreCollections, function ($a, $b){
            return -($a->getScore() <=> $b->getScore());
        });

        foreach ($this->scoreCollections as $collection) {
            if ($collection->check($result) === true) {
                $calculatedPoints = $collection->getScore();
                break;
            }
        }

        return $calculatedPoints;
    }

    private function checkCollection()
    {
        foreach ($this->scoreCollections as $collection) {
            if (!$collection instanceof ScoreInterface) {
                throw new \RuntimeException('Collection: ' . get_class($collection) . 'is not instanceof ' . ScoreInterface::class);
            }
        }
    }
}