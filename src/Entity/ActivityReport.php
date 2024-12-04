<?php

namespace App\Entity;

use App\Repository\ActivityReportRepository;
use App\Traits\TitleTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityReportRepository::class)]
class ActivityReport
{

    use TitleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["all"], inversedBy: 'activityReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $media = null;

    #[ORM\Column]
    private ?int $year = null;

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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }
}
