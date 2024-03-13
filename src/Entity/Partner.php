<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use App\Traits\TitleTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
class Partner
{
    use TitleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["all"], inversedBy: 'partners')]
    private ?Media $media = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column]
    private ?int $position = null;

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

    const TYPE_FINANCIAL   = 1;
    const TYPE_COLLABORATE = 2;
    public static function getListTypes($type = null): array|string
    {
        $types = [
            self::TYPE_FINANCIAL   => 'Financeur',
            self::TYPE_COLLABORATE   => 'Collaborateur',
        ];

        return $type === null ? $types : $types[$type];
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
