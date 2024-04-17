<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    private ?Establishment $location = null;

    /**
     * @var Collection<int, Comedian>
     */
    #[ORM\ManyToMany(targetEntity: Comedian::class, inversedBy: 'events')]
    private Collection $comedians;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duration = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $soldTickets;

    #[ORM\OneToOne(inversedBy: 'event', cascade: ['persist', 'remove'])]
    private ?Image $poster = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'organizedEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ComedyClub $comedyClub = null;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $bookings;

    public function __construct()
    {
        $this->comedians = new ArrayCollection();
        $this->soldTickets = new ArrayCollection();
        $this->bookings = new ArrayCollection();
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
}
