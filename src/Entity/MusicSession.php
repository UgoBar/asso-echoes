<?php

namespace App\Entity;

use App\Repository\MusicSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicSessionRepository::class)]
class MusicSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'musicSession', targetEntity: MusicDetail::class)]
    private Collection $musicDetails;

    public function __construct()
    {
        $this->musicDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, MusicDetail>
     */
    public function getMusicDetails(): Collection
    {
        return $this->musicDetails;
    }

    public function addMusicDetail(MusicDetail $musicDetail): static
    {
        if (!$this->musicDetails->contains($musicDetail)) {
            $this->musicDetails->add($musicDetail);
            $musicDetail->setMusicSession($this);
        }

        return $this;
    }

    public function removeMusicDetail(MusicDetail $musicDetail): static
    {
        if ($this->musicDetails->removeElement($musicDetail)) {
            // set the owning side to null (unless already changed)
            if ($musicDetail->getMusicSession() === $this) {
                $musicDetail->setMusicSession(null);
            }
        }

        return $this;
    }
}
