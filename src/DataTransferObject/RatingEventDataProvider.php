<?php
declare(strict_types=1);
namespace App\DataTransferObject;

/**
 * Auto generated data provider
 */
final class RatingEventDataProvider extends \Xervice\DataProvider\Business\Model\DataProvider\AbstractDataProvider implements \Xervice\DataProvider\Business\Model\DataProvider\DataProviderInterface
{
    /** @var \App\DataTransferObject\MatchDataProvider[] */
    protected $games = [];

    /** @var \App\DataTransferObject\UserRatingDataProvider[] */
    protected $users = [];


    /**
     * @return \App\DataTransferObject\MatchDataProvider[]
     */
    public function getGames(): array
    {
        return $this->games;
    }


    /**
     * @param \App\DataTransferObject\MatchDataProvider[] $games
     * @return RatingEventDataProvider
     */
    public function setGames(array $games)
    {
        $this->games = $games;

        return $this;
    }


    /**
     * @return RatingEventDataProvider
     */
    public function unsetGames()
    {
        $this->games = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasGames()
    {
        return ($this->games !== null && $this->games !== []);
    }


    /**
     * @param \App\DataTransferObject\MatchDataProvider $Game
     * @return RatingEventDataProvider
     */
    public function addGame(MatchDataProvider $Game)
    {
        $this->games[] = $Game; return $this;
    }


    /**
     * @return \App\DataTransferObject\UserRatingDataProvider[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }


    /**
     * @param \App\DataTransferObject\UserRatingDataProvider[] $users
     * @return RatingEventDataProvider
     */
    public function setUsers(array $users)
    {
        $this->users = $users;

        return $this;
    }


    /**
     * @return RatingEventDataProvider
     */
    public function unsetUsers()
    {
        $this->users = null;

        return $this;
    }


    /**
     * @return bool
     */
    public function hasUsers()
    {
        return ($this->users !== null && $this->users !== []);
    }


    /**
     * @param \App\DataTransferObject\UserRatingDataProvider $User
     * @return RatingEventDataProvider
     */
    public function addUser(UserRatingDataProvider $User)
    {
        $this->users[] = $User; return $this;
    }


    /**
     * @return array
     */
    protected function getElements(): array
    {
        return array (
          'games' =>
          array (
            'name' => 'games',
            'allownull' => false,
            'default' => '',
            'type' => '\\App\\DataTransferObject\\MatchDataProvider[]',
            'is_collection' => true,
            'is_dataprovider' => false,
            'isCamelCase' => false,
            'singleton' => 'Game',
            'singleton_type' => '\\App\\DataTransferObject\\MatchDataProvider',
          ),
          'users' =>
          array (
            'name' => 'users',
            'allownull' => false,
            'default' => '',
            'type' => '\\App\\DataTransferObject\\UserRatingDataProvider[]',
            'is_collection' => true,
            'is_dataprovider' => false,
            'isCamelCase' => false,
            'singleton' => 'User',
            'singleton_type' => '\\App\\DataTransferObject\\UserRatingDataProvider',
          ),
        );
    }
}
