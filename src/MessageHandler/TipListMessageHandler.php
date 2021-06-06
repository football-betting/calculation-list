<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Controller\CalculationListController;
use App\DataTransferObject\CalculationListDataProvider;
use App\DataTransferObject\TippListDataProvider;
use App\Persistence\CalculationListConfig;
use App\Calculation\Redis\RedisService;

class TipListMessageHandler
{
    private RedisService $redisService;

    /**
     * @param \App\Calculation\Redis\RedisService $redisService
     */
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function __invoke(TippListDataProvider $message)
    {
        try {
            $calculationListController = new CalculationListController();
            $calculationListController->saveList(CalculationListConfig::TIP_LIST_NAME, json_encode($message));
        } catch (\Throwable $e) {
            dump($e);
        }
    }
}
