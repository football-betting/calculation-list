<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\DataTransferObject\CalculationListDataProvider;
use App\Service\Redis\RedisService;

class TippListMessageHandler
{
    private RedisService $redisService;

    /**
     * @param \App\Service\Redis\RedisService $redisService
     */
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function __invoke(CalculationListDataProvider $message)
    {
        try {
            dump($message);
            // saveToDatabase
//            $this->redisService->set((string)$message->getIdent(), json_encode($message->toArray(), JSON_THROW_ON_ERROR));
        } catch (\Throwable $e) {
            dump($e);
        }
    }
}
