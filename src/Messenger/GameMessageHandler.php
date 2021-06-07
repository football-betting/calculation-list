<?php declare(strict_types=1);

namespace App\Messenger;

use App\Calculation\UserList;
use App\DataTransferObject\MatchListDataProvider;
use App\Redis\RedisRepository;

class GameMessageHandler
{
    private RedisRepository $redisRepository;
    /**
     * @var \App\Calculation\UserList
     */
    private UserList $userList;

    /**
     * @param \App\Redis\RedisRepository $redisRepository
     * @param \App\Calculation\UserList $userList
     */
    public function __construct(RedisRepository $redisRepository, UserList $userList)
    {
        $this->redisRepository = $redisRepository;
        $this->userList = $userList;
    }

    public function __invoke(MatchListDataProvider $matchListDataProvider)
    {
        $this->redisRepository->saveGames($matchListDataProvider);
        $this->userList->calculate();
    }
}
