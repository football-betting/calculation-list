<?php declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Entity\Listcache;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListCacheRepository  extends AbstractController
{
    /**
     * @var Listcache
     */
    private $listCacheEntity;

    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = $this->getDoctrine()->getManager();
        $this->listCacheEntity = new Listcache();
    }

    /**
     * @param string $listName
     * @return string
     */
    public function getList(string $listName): string
    {
        /** @var Listcache $result */
        $result = $this->entityManager->find(Listcache::class, $listName);

        return $result->getList();
    }

    /**
     * @param string $listName
     * @param string $list
     */
    public function saveList(string $listName, string $list): void
    {
        $this->listCacheEntity->setName($listName);
        $this->listCacheEntity->setList($list);

        $this->entityManager->persist($this->listCacheEntity);
        $this->entityManager->flush();
    }
}