<?php

namespace App\Service;

use App\Entity\LogoBlack;
use App\Entity\LogoWhite;
use App\Entity\Media;
use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;

class SiteVarsService
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

    public function getLogo(): Media|false
    {
        $logoBlack = count($this->entityManager->getRepository(LogoBlack::class)->findAll()) > 0 ? $this->entityManager->getRepository(LogoBlack::class)->findAll()[0] : null;
        if ($logoBlack && $logoBlack->getMedia())
            return $logoBlack->getMedia();

        return false;
    }

    public function getWhiteLogo(): Media|false
    {
        $logoWhite = count($this->entityManager->getRepository(LogoWhite::class)->findAll()) > 0 ? $this->entityManager->getRepository(LogoWhite::class)->findAll()[0] : null;
        if ($logoWhite && $logoWhite->getMedia())
            return $logoWhite->getMedia();

        return false;
    }

    public function getAdhesionLink(): string
    {
        $site = count($this->entityManager->getRepository(Site::class)->findAll()) > 0 ? $this->entityManager->getRepository(Site::class)->findAll()[0] : null;
        if ($site !== null & $site->getAdhesion() !== null)
            return $site->getAdhesion();

        return '#';
    }

    public function getDonationLink(): string
    {
        $site = count($this->entityManager->getRepository(Site::class)->findAll()) > 0 ? $this->entityManager->getRepository(Site::class)->findAll()[0] : null;
        if ($site !== null & $site->getDonation() !== null)
            return $site->getDonation();

        return '#';
    }

    public function getPodcastLink(): string
    {
        $site = count($this->entityManager->getRepository(Site::class)->findAll()) > 0 ? $this->entityManager->getRepository(Site::class)->findAll()[0] : null;
        if ($site !== null & $site->getPodcastLink() !== null)
            return $site->getPodcastLink();

        return '#';
    }
}
