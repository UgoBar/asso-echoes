<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use App\Traits\TitleTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    use TitleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["all"], inversedBy: 'galleries')]
    private ?Media $media = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $credit = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $type = null;

    const TYPE_WIDE   = 1;
    const TYPE_TALL   = 2;
    const TYPE_SQUARE = 3;
    public static function getListTypes($type = null): array|string
    {
        $types = [
            self::TYPE_WIDE   => 'Horizontale',
            self::TYPE_TALL   => 'Verticale',
            self::TYPE_SQUARE => 'Carré'
        ];

        return $type === null ? $types : $types[$type];
    }

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

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    public function setCredit(?string $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): static
    {
        $this->type = $type;

        return $this;
    }
}
