<?php

namespace App\Entity;

use App\Repository\MusicDetailPictureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicDetailPictureRepository::class)]
class MusicDetailPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["all"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $media = null;

    #[ORM\ManyToOne(inversedBy: 'musicDetailPictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MusicDetail $musicDetail = null;

    #[ORM\Column]
    private ?bool $isFavorite = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMusicDetail(): ?musicDetail
    {
        return $this->musicDetail;
    }

    public function setMusicDetail(?musicDetail $musicDetail): static
    {
        $this->musicDetail = $musicDetail;

        return $this;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): static
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }
}
