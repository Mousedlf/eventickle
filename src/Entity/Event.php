<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['establishment:read', 'event:read', 'invitation:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Groups(['event:read', 'invitation:read'])]
    private ?Establishment $location = null;

    /**
     * @var Collection<int, Comedian>
     */
    #[ORM\ManyToMany(targetEntity: Comedian::class, inversedBy: 'events')]
    #[Groups(['establishment:read', 'event:read', 'invitation:read'])]
    private Collection $comedians;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['establishment:read', 'event:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    #[Groups(['establishment:read', 'event:read', 'invitation:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['establishment:read', 'invitation:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['establishment:read', 'event:read', 'invitation:read'])]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['establishment:read', 'event:read', 'invitation:read'])]
    private ?string $duration = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $soldTickets;

    #[ORM\OneToOne(inversedBy: 'event', cascade: ['persist', 'remove'])]
    #[Groups(['establishment:read', 'event:read'])]
    private ?Image $poster = null;

    #[ORM\Column]
    #[Groups(['establishment:read', 'event:read'])]
    private ?bool $status = null;

    #[ORM\Column]
    #[Groups(['establishment:read', 'event:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'organizedEvents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['establishment:read', 'event:read'])]
    private ?ComedyClub $comedyClub = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $bookings;

    /**
     * @var Collection<int, Invite>
     */
    #[ORM\OneToMany(targetEntity: Invite::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $invites;

    public function __construct()
    {
        $this->comedians = new ArrayCollection();
        $this->soldTickets = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->invites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Establishment
    {
        return $this->location;
    }

    public function setLocation(?Establishment $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Comedian>
     */
    public function getComedians(): Collection
    {
        return $this->comedians;
    }

    public function addComedian(Comedian $comedian): static
    {
        if (!$this->comedians->contains($comedian)) {
            $this->comedians->add($comedian);
        }

        return $this;
    }

    public function removeComedian(Comedian $comedian): static
    {
        $this->comedians->removeElement($comedian);

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getSoldTickets(): Collection
    {
        return $this->soldTickets;
    }

    public function addSoldTicket(Ticket $soldTicket): static
    {
        if (!$this->soldTickets->contains($soldTicket)) {
            $this->soldTickets->add($soldTicket);
            $soldTicket->setEvent($this);
        }

        return $this;
    }

    public function removeSoldTicket(Ticket $soldTicket): static
    {
        if ($this->soldTickets->removeElement($soldTicket)) {
            // set the owning side to null (unless already changed)
            if ($soldTicket->getEvent() === $this) {
                $soldTicket->setEvent(null);
            }
        }

        return $this;
    }

    public function getPoster(): ?Image
    {
        return $this->poster;
    }

    public function setPoster(?Image $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getComedyClub(): ?ComedyClub
    {
        return $this->comedyClub;
    }

    public function setComedyClub(?ComedyClub $comedyClub): static
    {
        $this->comedyClub = $comedyClub;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setEvent($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getEvent() === $this) {
                $booking->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invite>
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(Invite $invite): static
    {
        if (!$this->invites->contains($invite)) {
            $this->invites->add($invite);
            $invite->setEvent($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): static
    {
        if ($this->invites->removeElement($invite)) {
            // set the owning side to null (unless already changed)
            if ($invite->getEvent() === $this) {
                $invite->setEvent(null);
            }
        }

        return $this;
    }
}
