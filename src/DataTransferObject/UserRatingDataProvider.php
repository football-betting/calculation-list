<?php
declare(strict_types=1);
namespace App\DataTransferObject;

/**
 * Auto generated data provider
 */
final class UserRatingDataProvider extends \Xervice\DataProvider\Business\Model\DataProvider\AbstractDataProvider implements \Xervice\DataProvider\Business\Model\DataProvider\DataProviderInterface
{
    /** @var string */
    protected $name;

    /** @var int */
    protected $position;

    /** @var int */
    protected $scoreSum;

    /** @var int */
    protected $sumWinExact;

    /** @var int */
    protected $sumScoreDiff;

    /** @var int */
    protected $sumTeam;

    /** @var int */
    protected $extraPoint;

    /** @var \App\DataTransferObject\CalculationDataProvider[] */
    protected $tips = [];


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return UserRatingDataProvider
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetName()
    {
        $this->name = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasName()
    {
        return ($this->name !== null && $this->name !== []);
    }


    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }


    /**
     * @param int $position
     * @return UserRatingDataProvider
     */
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetPosition()
    {
        $this->position = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasPosition()
    {
        return ($this->position !== null && $this->position !== []);
    }


    /**
     * @return int
     */
    public function getScoreSum(): int
    {
        return $this->scoreSum;
    }


    /**
     * @param int $scoreSum
     * @return UserRatingDataProvider
     */
    public function setScoreSum(int $scoreSum)
    {
        $this->scoreSum = $scoreSum;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetScoreSum()
    {
        $this->scoreSum = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasScoreSum()
    {
        return ($this->scoreSum !== null && $this->scoreSum !== []);
    }


    /**
     * @return int
     */
    public function getSumWinExact(): int
    {
        return $this->sumWinExact;
    }


    /**
     * @param int $sumWinExact
     * @return UserRatingDataProvider
     */
    public function setSumWinExact(int $sumWinExact)
    {
        $this->sumWinExact = $sumWinExact;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetSumWinExact()
    {
        $this->sumWinExact = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasSumWinExact()
    {
        return ($this->sumWinExact !== null && $this->sumWinExact !== []);
    }


    /**
     * @return int
     */
    public function getSumScoreDiff(): int
    {
        return $this->sumScoreDiff;
    }


    /**
     * @param int $sumScoreDiff
     * @return UserRatingDataProvider
     */
    public function setSumScoreDiff(int $sumScoreDiff)
    {
        $this->sumScoreDiff = $sumScoreDiff;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetSumScoreDiff()
    {
        $this->sumScoreDiff = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasSumScoreDiff()
    {
        return ($this->sumScoreDiff !== null && $this->sumScoreDiff !== []);
    }


    /**
     * @return int
     */
    public function getSumTeam(): int
    {
        return $this->sumTeam;
    }


    /**
     * @param int $sumTeam
     * @return UserRatingDataProvider
     */
    public function setSumTeam(int $sumTeam)
    {
        $this->sumTeam = $sumTeam;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetSumTeam()
    {
        $this->sumTeam = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasSumTeam()
    {
        return ($this->sumTeam !== null && $this->sumTeam !== []);
    }


    /**
     * @return int
     */
    public function getExtraPoint(): int
    {
        return $this->extraPoint;
    }


    /**
     * @param int $extraPoint
     * @return UserRatingDataProvider
     */
    public function setExtraPoint(int $extraPoint)
    {
        $this->extraPoint = $extraPoint;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetExtraPoint()
    {
        $this->extraPoint = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasExtraPoint()
    {
        return ($this->extraPoint !== null && $this->extraPoint !== []);
    }


    /**
     * @return \App\DataTransferObject\CalculationDataProvider[]
     */
    public function getTips(): array
    {
        return $this->tips;
    }


    /**
     * @param \App\DataTransferObject\CalculationDataProvider[] $tips
     * @return UserRatingDataProvider
     */
    public function setTips(array $tips)
    {
        $this->tips = $tips;

        return $this;
    }


    /**
     * @return UserRatingDataProvider
     */
    public function unsetTips()
    {
        $this->tips = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasTips()
    {
        return ($this->tips !== null && $this->tips !== []);
    }


    /**
     * @param \App\DataTransferObject\CalculationDataProvider $Tip
     * @return UserRatingDataProvider
     */
    public function addTip(CalculationDataProvider $Tip)
    {
        $this->tips[] = $Tip; return $this;
    }


    /**
     * @return array
     */
    protected function getElements(): array
    {
        return array (
          'name' =>
          array (
            'name' => 'name',
            'allownull' => false,
            'default' => '',
            'type' => 'string',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'position' =>
          array (
            'name' => 'position',
            'allownull' => false,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'scoreSum' =>
          array (
            'name' => 'scoreSum',
            'allownull' => false,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'sumWinExact' =>
          array (
            'name' => 'sumWinExact',
            'allownull' => false,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'sumScoreDiff' =>
          array (
            'name' => 'sumScoreDiff',
            'allownull' => false,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'sumTeam' =>
          array (
            'name' => 'sumTeam',
            'allownull' => false,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'extraPoint' =>
          array (
            'name' => 'extraPoint',
            'allownull' => false,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'tips' =>
          array (
            'name' => 'tips',
            'allownull' => false,
            'default' => '',
            'type' => '\\App\\DataTransferObject\\CalculationDataProvider[]',
            'is_collection' => true,
            'is_dataprovider' => false,
            'isCamelCase' => false,
            'singleton' => 'Tip',
            'singleton_type' => '\\App\\DataTransferObject\\CalculationDataProvider',
          ),
        );
    }
}
