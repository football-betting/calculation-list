<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Calculation\UserList;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Redis\RedisRepository;

class UserTipMessageHandler
{
    private RedisRepository $redisRepository;
    /**
     * @var \App\Calculation\UserList
     */
    private UserList $userList;

    /**
     * @param \App\Redis\RedisRepository $redisRepository
     */
    public function __construct(RedisRepository $redisRepository, UserList $userList)
    {
        $this->redisRepository = $redisRepository;
        $this->userList = $userList;
    }

    public function __invoke(TippListDataProvider $matchListDataProvider)
    {
        $username = '';
        foreach ($matchListDataProvider->getData() as $tippDataProvider) {
            if ($username === '') {
                $username = $tippDataProvider->getUser();
            }
            if ($username !== $tippDataProvider->getUser()) {
                throw new \RuntimeException('Username is not unique: ' . $tippDataProvider->getUser() . ' | '. $username);
            }
        }

        $this->redisRepository->saveUserTips($username, $matchListDataProvider);
        $this->userList->calculate();
    }
}
