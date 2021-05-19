<?php declare(strict_types=1);

namespace App\Business;

interface CacheListFacadeInterface
{
    /**
     * @param string $listName
     * @return string
     */
    public function getList(string $listName): string;

    /**
     * @param string $listName
     * @param string $list
     */
    public function saveList(string $listName, string $list): void;
}