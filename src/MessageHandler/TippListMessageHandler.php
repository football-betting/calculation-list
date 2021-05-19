<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Controller\CalculationListController;
use App\DataTransferObject\CalculationListDataProvider;
use App\Persistence\CalculationListConfig;
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
//            dump($message);
            $calculationListController = new CalculationListController();
            $calculationListController->saveList(CalculationListConfig::TIPP_LIST_NAME, json_encode($message));
        } catch (\Throwable $e) {
            dump($e);
        }
    }
}
