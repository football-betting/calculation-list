<?php declare(strict_types=1);

namespace App\Business;

use App\Persistence\Repository\ListCacheRepository;

class CacheListFacade implements CacheListFacadeInterface
{

    /**
     * @var ListCacheRepository
     */
    private $listCacheRepository;

    public function __construct()
    {
        $this->listCacheRepository = new ListCacheRepository();
    }

    /**
     * @param string $listName
     */
    public function getList(string $listName): string
    {
        return $this->listCacheRepository->getList($listName);
    }

    /**
     * @param string $listName
     * @param string $list
     */
    public function saveList(string $listName, string $list): void
    {
        $this->listCacheRepository->saveList($listName, $list);
    }
}