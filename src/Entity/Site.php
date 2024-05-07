<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\ManyToOne]
    private ?Media $pressReview = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adhesion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $donation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $podcastLink = null;

    #[ORM\Column(nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getPressReview(): ?Media
    {
        return $this->pressReview;
    }

    public function setPressReview(?Media $pressReview): static
    {
        $this->pressReview = $pressReview;

        return $this;
    }

    public function getAdhesion(): ?string
    {
        return $this->adhesion;
    }

    public function setAdhesion(?string $adhesion): static
    {
        $this->adhesion = $adhesion;

        return $this;
    }

    public function getDonation(): ?string
    {
        return $this->donation;
    }

    public function setDonation(?string $donation): static
    {
        $this->donation = $donation;

        return $this;
    }

    public function getPodcastLink(): ?string
    {
        return $this->podcastLink;
    }

    public function setPodcastLink(?string $podcastLink): static
    {
        $this->podcastLink = $podcastLink;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
