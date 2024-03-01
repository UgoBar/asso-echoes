<?php

namespace App\Entity;

use App\Repository\MemoryboxRepository;
use App\Traits\TitleTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoryboxRepository::class)]
class Memorybox
{
    use TitleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["all"], inversedBy: 'memoryBanners')]
    private ?Media $banner = null;

    #[ORM\ManyToOne(cascade: ["all"], inversedBy: 'memoryMedias')]
    private ?Media $media = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $firstText = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $secondText = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanner(): ?Media
    {
        return $this->banner;
    }

    public function setBanner(?Media $banner): static
    {
        $this->banner = $banner;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getFirstText(): ?string
    {
        return $this->firstText;
    }

    public function setFirstText(?string $firstText): static
    {
        $this->firstText = $firstText;

        return $this;
    }

    public function getSecondText(): ?string
    {
        return $this->secondText;
    }

    public function setSecondText(?string $secondText): static
    {
        $this->secondText = $secondText;

        return $this;
    }
}
