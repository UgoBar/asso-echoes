<?php

namespace App\Service;

use App\Entity\LogoBlack;
use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;

class MainLogoService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function getLogo(): Media|false
    {
        $logoBlack = count($this->entityManager->getRepository(LogoBlack::class)->findAll()) > 0 ? $this->entityManager->getRepository(LogoBlack::class)->findAll()[0] : null;
        if ($logoBlack && $logoBlack->getMedia())
            return $logoBlack->getMedia();

        return false;
    }
}
