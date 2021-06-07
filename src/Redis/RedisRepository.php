<?php declare(strict_types=1);

namespace App\Redis;

use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TippListDataProvider;

final class RedisRepository
{
    private RedisService $redisService;

    private const USER = 'user:';
    private const GAMES = 'game';

    /**
     * @param \App\Redis\RedisService $redisService
     */
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    /**
     * @param string $username
     * @param \App\DataTransferObject\TippListDataProvider $tippListDataProvider
     */
    public function saveUserTips(string $username, TippListDataProvider $tippListDataProvider): void
    {
        $this->redisService->set(self::USER . $username, json_encode($tippListDataProvider->toArray()));
    }

    /**
     * @param \App\DataTransferObject\MatchListDataProvider $matchListDataProvider
     */
    public function saveGames(MatchListDataProvider $matchListDataProvider): void
    {
        $this->redisService->set(self::GAMES, json_encode($matchListDataProvider->toArray()));
    }

    /**
     * @return \App\DataTransferObject\TippListDataProvider[]
     */
    public function getUsersTips(): array
    {
        $keys = $this->redisService->getKeys(self::USER . '*');
        foreach ($keys as $id => $key) {
            $keys[$id] = str_replace($this->redisService->getPrefix(), '', $key);
        }
        $users =  $this->redisService->mget($keys);
        $users = array_filter($users);
        $tippList = [];
        foreach ($users as $user) {
            $tippListDataProvider = new TippListDataProvider();
            $tippListDataProvider->fromArray(json_decode($user, true));

            $tippList[] = $tippListDataProvider;
        }

        return $tippList;
    }

    /**
     * @return \App\DataTransferObject\MatchListDataProvider
     */
    public function getGames(): MatchListDataProvider
    {
        $games = $this->redisService->get(self::GAMES);

        $matchListDataProvider = new MatchListDataProvider();
        $matchListDataProvider->fromArray(json_decode($games, true));

        return $matchListDataProvider;
    }


}
