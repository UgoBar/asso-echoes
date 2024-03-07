<?php

namespace App\Service;

use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;

class MainColorService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function getColor(): string
    {
        $site = count($this->entityManager->getRepository(Site::class)->findAll()) > 0 ? $this->entityManager->getRepository(Site::class)->findAll()[0] : null;
        if ($site !== null & $site->getColor() !== null)
            return $site->getColor();

        return '#ff5500';
    }
}
