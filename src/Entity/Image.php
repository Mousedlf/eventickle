<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'poster', cascade: ['persist', 'remove'])]
    private ?Event $event = null;

    #[ORM\OneToOne(mappedBy: 'profilePicture', cascade: ['persist', 'remove'])]
    private ?Comedian $comedian = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        // unset the owning side of the relation if necessary
        if ($event === null && $this->event !== null) {
            $this->event->setPoster(null);
        }

        // set the owning side of the relation if necessary
        if ($event !== null && $event->getPoster() !== $this) {
            $event->setPoster($this);
        }

        $this->event = $event;

        return $this;
    }

    public function getComedian(): ?Comedian
    {
        return $this->comedian;
    }

    public function setComedian(?Comedian $comedian): static
    {
        // unset the owning side of the relation if necessary
        if ($comedian === null && $this->comedian !== null) {
            $this->comedian->setProfilePicture(null);
        }

        // set the owning side of the relation if necessary
        if ($comedian !== null && $comedian->getProfilePicture() !== $this) {
            $comedian->setProfilePicture($this);
        }

        $this->comedian = $comedian;

        return $this;
    }
}
