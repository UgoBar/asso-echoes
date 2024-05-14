<?php

namespace App\Entity;

use App\Repository\MusicDetailRepository;
use App\Traits\TitleTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicDetailRepository::class)]
class MusicDetail
{
    use TitleTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'musicDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MusicSession $musicSession = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'musicDetail', targetEntity: MusicDetailPicture::class)]
    private Collection $musicDetailPictures;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeLink = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $position = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $collaborator = null;

    #[ORM\Column(length: 255)]
    private ?string $artist = null;

    #[ORM\ManyToOne]
    private ?Podcast $podcast = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->musicDetailPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMusicSession(): ?musicSession
    {
        return $this->musicSession;
    }

    public function setMusicSession(?musicSession $musicSession): static
    {
        $this->musicSession = $musicSession;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, MusicDetailPicture>
     */
    public function getMusicDetailPictures(): Collection
    {
        return $this->musicDetailPictures;
    }

    public function addMusicDetailPicture(MusicDetailPicture $musicDetailPicture): static
    {
        if (!$this->musicDetailPictures->contains($musicDetailPicture)) {
            $this->musicDetailPictures->add($musicDetailPicture);
            $musicDetailPicture->setMusicDetail($this);
        }

        return $this;
    }

    public function removeMusicDetailPicture(MusicDetailPicture $musicDetailPicture): static
    {
        if ($this->musicDetailPictures->removeElement($musicDetailPicture)) {
            // set the owning side to null (unless already changed)
            if ($musicDetailPicture->getMusicDetail() === $this) {
                $musicDetailPicture->setMusicDetail(null);
            }
        }

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): static
    {
        $this->youtubeLink = $youtubeLink;

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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCollaborator(): ?string
    {
        return $this->collaborator;
    }

    public function setCollaborator(?string $collaborator): static
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getPodcast(): ?Podcast
    {
        return $this->podcast;
    }

    public function setPodcast(?Podcast $podcast): static
    {
        $this->podcast = $podcast;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
