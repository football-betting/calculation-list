<?php
declare(strict_types=1);
namespace App\DataTransferObject;

/**
 * Auto generated data provider
 */
final class ResultDataProvider extends \Xervice\DataProvider\Business\Model\DataProvider\AbstractDataProvider implements \Xervice\DataProvider\Business\Model\DataProvider\DataProviderInterface
{
    /** @var int */
    protected $scoreTeam1;

    /** @var int */
    protected $scoreTeam2;

    /** @var int */
    protected $tipTeam1;

    /** @var int */
    protected $tipTeam2;


    /**
     * @return int
     */
    public function getScoreTeam1(): ?int
    {
        return $this->scoreTeam1;
    }


    /**
     * @param int $scoreTeam1
     * @return ResultDataProvider
     */
    public function setScoreTeam1(?int $scoreTeam1 = null)
    {
        $this->scoreTeam1 = $scoreTeam1;

        return $this;
    }


    /**
     * @return ResultDataProvider
     */
    public function unsetScoreTeam1()
    {
        $this->scoreTeam1 = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasScoreTeam1()
    {
        return ($this->scoreTeam1 !== null && $this->scoreTeam1 !== []);
    }


    /**
     * @return int
     */
    public function getScoreTeam2(): ?int
    {
        return $this->scoreTeam2;
    }


    /**
     * @param int $scoreTeam2
     * @return ResultDataProvider
     */
    public function setScoreTeam2(?int $scoreTeam2 = null)
    {
        $this->scoreTeam2 = $scoreTeam2;

        return $this;
    }


    /**
     * @return ResultDataProvider
     */
    public function unsetScoreTeam2()
    {
        $this->scoreTeam2 = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasScoreTeam2()
    {
        return ($this->scoreTeam2 !== null && $this->scoreTeam2 !== []);
    }


    /**
     * @return int
     */
    public function getTipTeam1(): ?int
    {
        return $this->tipTeam1;
    }


    /**
     * @param int $tipTeam1
     * @return ResultDataProvider
     */
    public function setTipTeam1(?int $tipTeam1 = null)
    {
        $this->tipTeam1 = $tipTeam1;

        return $this;
    }


    /**
     * @return ResultDataProvider
     */
    public function unsetTipTeam1()
    {
        $this->tipTeam1 = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasTipTeam1()
    {
        return ($this->tipTeam1 !== null && $this->tipTeam1 !== []);
    }


    /**
     * @return int
     */
    public function getTipTeam2(): ?int
    {
        return $this->tipTeam2;
    }


    /**
     * @param int $tipTeam2
     * @return ResultDataProvider
     */
    public function setTipTeam2(?int $tipTeam2 = null)
    {
        $this->tipTeam2 = $tipTeam2;

        return $this;
    }


    /**
     * @return ResultDataProvider
     */
    public function unsetTipTeam2()
    {
        $this->tipTeam2 = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasTipTeam2()
    {
        return ($this->tipTeam2 !== null && $this->tipTeam2 !== []);
    }


    /**
     * @return array
     */
    protected function getElements(): array
    {
        return array (
          'scoreTeam1' =>
          array (
            'name' => 'scoreTeam1',
            'allownull' => true,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'scoreTeam2' =>
          array (
            'name' => 'scoreTeam2',
            'allownull' => true,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'tipTeam1' =>
          array (
            'name' => 'tipTeam1',
            'allownull' => true,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
          'tipTeam2' =>
          array (
            'name' => 'tipTeam2',
            'allownull' => true,
            'default' => '',
            'type' => 'int',
            'is_collection' => false,
            'is_dataprovider' => false,
            'isCamelCase' => false,
          ),
        );
    }
}
