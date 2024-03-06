<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[Vich\Uploadable]
class Media
{
    #[Vich\UploadableField(mapping: 'uploads', fileNameProperty: 'picture')]
    private ?File $imageFile = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alt = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Podcast::class)]
    private Collection $podcasts;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Number::class)]
    private Collection $numbers;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: LogoBlack::class)]
    private Collection $logoBlacks;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: LogoWhite::class)]
    private Collection $logoWhites;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Gallery::class)]
    private Collection $galleries;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Asso::class)]
    private Collection $assos;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: TeamMember::class)]
    private Collection $teamMembers;

    #[ORM\OneToMany(mappedBy: 'banner', targetEntity: Radiobox::class)]
    private Collection $radioboxes;

    #[ORM\OneToMany(mappedBy: 'banner', targetEntity: Memorybox::class)]
    private Collection $memoryBanners;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Memorybox::class)]
    private Collection $memoryMedias;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Press::class)]
    private Collection $presses;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Partner::class)]
    private Collection $partners;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Rent::class)]
    private Collection $rents;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Organize::class)]
    private Collection $organizes;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->podcasts = new ArrayCollection();
        $this->numbers = new ArrayCollection();
        $this->logoBlacks = new ArrayCollection();
        $this->logoWhites = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->assos = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
        $this->radioboxes = new ArrayCollection();
        $this->memoryBanners = new ArrayCollection();
        $this->memoryMedias = new ArrayCollection();
        $this->presses = new ArrayCollection();
        $this->partners = new ArrayCollection();
        $this->rents = new ArrayCollection();
        $this->organizes = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }


    /**
     * @param \Symfony\Component\HttpFoundation\File\File|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable());
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @return Collection<int, Podcast>
     */
    public function getPodcasts(): Collection
    {
        return $this->podcasts;
    }

    public function addPodcast(Podcast $podcast): static
    {
        if (!$this->podcasts->contains($podcast)) {
            $this->podcasts->add($podcast);
            $podcast->setMedia($this);
        }

        return $this;
    }

    public function removePodcast(Podcast $podcast): static
    {
        if ($this->podcasts->removeElement($podcast)) {
            // set the owning side to null (unless already changed)
            if ($podcast->getMedia() === $this) {
                $podcast->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Number>
     */
    public function getNumbers(): Collection
    {
        return $this->numbers;
    }

    public function addNumber(Number $number): static
    {
        if (!$this->numbers->contains($number)) {
            $this->numbers->add($number);
            $number->setMedia($this);
        }

        return $this;
    }

    public function removeNumber(Number $number): static
    {
        if ($this->numbers->removeElement($number)) {
            // set the owning side to null (unless already changed)
            if ($number->getMedia() === $this) {
                $number->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LogoBlack>
     */
    public function getLogoBlacks(): Collection
    {
        return $this->logoBlacks;
    }

    public function addLogoBlack(LogoBlack $logoBlack): static
    {
        if (!$this->logoBlacks->contains($logoBlack)) {
            $this->logoBlacks->add($logoBlack);
            $logoBlack->setMedia($this);
        }

        return $this;
    }

    public function removeLogoBlack(LogoBlack $logoBlack): static
    {
        if ($this->logoBlacks->removeElement($logoBlack)) {
            // set the owning side to null (unless already changed)
            if ($logoBlack->getMedia() === $this) {
                $logoBlack->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LogoWhite>
     */
    public function getLogoWhites(): Collection
    {
        return $this->logoWhites;
    }

    public function addLogoWhite(LogoWhite $logoWhite): static
    {
        if (!$this->logoWhites->contains($logoWhite)) {
            $this->logoWhites->add($logoWhite);
            $logoWhite->setMedia($this);
        }

        return $this;
    }

    public function removeLogoWhite(LogoWhite $logoWhite): static
    {
        if ($this->logoWhites->removeElement($logoWhite)) {
            // set the owning side to null (unless already changed)
            if ($logoWhite->getMedia() === $this) {
                $logoWhite->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries->add($gallery);
            $gallery->setMedia($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->galleries->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getMedia() === $this) {
                $gallery->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Asso>
     */
    public function getAssos(): Collection
    {
        return $this->assos;
    }

    public function addAsso(Asso $asso): static
    {
        if (!$this->assos->contains($asso)) {
            $this->assos->add($asso);
            $asso->setMedia($this);
        }

        return $this;
    }

    public function removeAsso(Asso $asso): static
    {
        if ($this->assos->removeElement($asso)) {
            // set the owning side to null (unless already changed)
            if ($asso->getMedia() === $this) {
                $asso->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamMember>
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(TeamMember $teamMember): static
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers->add($teamMember);
            $teamMember->setMedia($this);
        }

        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): static
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getMedia() === $this) {
                $teamMember->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Radiobox>
     */
    public function getRadioboxes(): Collection
    {
        return $this->radioboxes;
    }

    public function addRadiobox(Radiobox $radiobox): static
    {
        if (!$this->radioboxes->contains($radiobox)) {
            $this->radioboxes->add($radiobox);
            $radiobox->setBanner($this);
        }

        return $this;
    }

    public function removeRadiobox(Radiobox $radiobox): static
    {
        if ($this->radioboxes->removeElement($radiobox)) {
            // set the owning side to null (unless already changed)
            if ($radiobox->getBanner() === $this) {
                $radiobox->setBanner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Memorybox>
     */
    public function getMemoryBanners(): Collection
    {
        return $this->memoryBanners;
    }

    public function addMemoryBanner(Memorybox $memoryBanner): static
    {
        if (!$this->memoryBanners->contains($memoryBanner)) {
            $this->memoryBanners->add($memoryBanner);
            $memoryBanner->setBanner($this);
        }

        return $this;
    }

    public function removeMemoryBanner(Memorybox $memoryBanner): static
    {
        if ($this->memoryBanners->removeElement($memoryBanner)) {
            // set the owning side to null (unless already changed)
            if ($memoryBanner->getBanner() === $this) {
                $memoryBanner->setBanner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Memorybox>
     */
    public function getMemoryMedias(): Collection
    {
        return $this->memoryMedias;
    }

    public function addMemoryMedia(Memorybox $memoryMedia): static
    {
        if (!$this->memoryMedias->contains($memoryMedia)) {
            $this->memoryMedias->add($memoryMedia);
            $memoryMedia->setMedia($this);
        }

        return $this;
    }

    public function removeMemoryMedia(Memorybox $memoryMedia): static
    {
        if ($this->memoryMedias->removeElement($memoryMedia)) {
            // set the owning side to null (unless already changed)
            if ($memoryMedia->getMedia() === $this) {
                $memoryMedia->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Press>
     */
    public function getPresses(): Collection
    {
        return $this->presses;
    }

    public function addPress(Press $press): static
    {
        if (!$this->presses->contains($press)) {
            $this->presses->add($press);
            $press->setMedia($this);
        }

        return $this;
    }

    public function removePress(Press $press): static
    {
        if ($this->presses->removeElement($press)) {
            // set the owning side to null (unless already changed)
            if ($press->getMedia() === $this) {
                $press->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Partner>
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): static
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->setMedia($this);
        }

        return $this;
    }

    public function removePartner(Partner $partner): static
    {
        if ($this->partners->removeElement($partner)) {
            // set the owning side to null (unless already changed)
            if ($partner->getMedia() === $this) {
                $partner->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rent>
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): static
    {
        if (!$this->rents->contains($rent)) {
            $this->rents->add($rent);
            $rent->setMedia($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): static
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getMedia() === $this) {
                $rent->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organize>
     */
    public function getOrganizes(): Collection
    {
        return $this->organizes;
    }

    public function addOrganize(Organize $organize): static
    {
        if (!$this->organizes->contains($organize)) {
            $this->organizes->add($organize);
            $organize->setMedia($this);
        }

        return $this;
    }

    public function removeOrganize(Organize $organize): static
    {
        if ($this->organizes->removeElement($organize)) {
            // set the owning side to null (unless already changed)
            if ($organize->getMedia() === $this) {
                $organize->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setMedia($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getMedia() === $this) {
                $contact->setMedia(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
