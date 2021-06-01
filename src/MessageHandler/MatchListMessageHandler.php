<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Controller\CalculationListController;
use App\DataTransferObject\MatchListDataProvider;
use App\DataTransferObject\TestDataProvider;
use App\Persistence\CalculationListConfig;
use App\Service\Redis\RedisService;

class MatchListMessageHandler
{
    private RedisService $redisService;

    /**
     * @param \App\Service\Redis\RedisService $redisService
     */
    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function __invoke(MatchListDataProvider $message)
    {
        try {
            $calculationListController = new CalculationListController();
            $calculationListController->saveList(CalculationListConfig::MATCH_LIST_NAME, json_encode($message));

            $calculationListController->calculateList();

            $this->redisService->set(
                (string)$message->getIdent(),
                json_encode(
                    $calculationListController->getList(CalculationListConfig::CALC_LIST_NAME),
                    JSON_THROW_ON_ERROR)
            );
        } catch (\Throwable $e) {
            dump($e);
        }
    }
}
