<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Listcache
 *
 * @ORM\Table(name="ListCache")
 * @ORM\Entity
 */
class Listcache
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="list", type="blob", length=16777215, nullable=false)
     */
    private $list;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getList(): string
    {
        return $this->list;
    }

    /**
     * @param string $list
     */
    public function setList(string $list): void
    {
        $this->list = $list;
    }
}
