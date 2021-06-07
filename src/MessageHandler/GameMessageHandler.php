<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\DataTransferObject\MatchListDataProvider;
use App\Redis\RedisRepository;

class GameMessageHandler
{
    private RedisRepository $redisRepository;

    /**
     * @param \App\Redis\RedisRepository $redisRepository
     */
    public function __construct(RedisRepository $redisRepository)
    {
        $this->redisRepository = $redisRepository;
    }

    public function __invoke(MatchListDataProvider $matchListDataProvider)
    {

    }
}
