<?php

namespace App\Entity;

use App\Repository\EstablishmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: EstablishmentRepository::class)]
class Establishment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["establishment:read"])]
    private ?int $id = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'location')]
    #[Groups(["establishment:read"])]
    private Collection $events;

    #[ORM\Column(length: 255)]
    #[Groups(["establishment:read"])]
    private ?string $siret = null;

    #[ORM\Column(length: 255)]
    #[Groups(["establishment:read"])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(["establishment:read"])]
    private ?string $address = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(["establishment:read"])]
    private ?array $accessibility = null;

    #[ORM\Column(length: 255)]
    #[Groups(["establishment:read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["establishment:read"])]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, Invite>
     */
    #[ORM\OneToMany(targetEntity: Invite::class, mappedBy: 'sentToEstablishment')]
    #[Groups(["establishment:read"])]
    private Collection $receivedInvites;

    /**
     * @var Collection<int, Availability>
     */
    #[ORM\ManyToMany(targetEntity: Availability::class, inversedBy: 'establishments')]
    #[Groups(["establishment:read"])]
    private Collection $availabilities;

    /**
     * @var Collection<int, Equipment>
     */
    #[ORM\ManyToMany(targetEntity: Equipment::class, inversedBy: 'establishments')]
    #[Groups(["establishment:read"])]
    private Collection $equipments;

    /**
     * @var Collection<int, Booking>
     */
    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'location')]
    #[Groups(["establishment:read"])]
    private Collection $bookings;

    #[ORM\OneToOne(inversedBy: 'establishment', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->receivedInvites = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setLocation($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getLocation() === $this) {
                $event->setLocation(null);
            }
        }

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAccessibility(): ?array
    {
        return $this->accessibility;
    }

    public function setAccessibility(?array $accessibility): static
    {
        $this->accessibility = $accessibility;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Invite>
     */
    public function getReceivedInvites(): Collection
    {
        return $this->receivedInvites;
    }

    public function addReceivedInvite(Invite $receivedInvite): static
    {
        if (!$this->receivedInvites->contains($receivedInvite)) {
            $this->receivedInvites->add($receivedInvite);
            $receivedInvite->setSentToEstablishment($this);
        }

        return $this;
    }

    public function removeReceivedInvite(Invite $receivedInvite): static
    {
        if ($this->receivedInvites->removeElement($receivedInvite)) {
            // set the owning side to null (unless already changed)
            if ($receivedInvite->getSentToEstablishment() === $this) {
                $receivedInvite->setSentToEstablishment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Availability>
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): static
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities->add($availability);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): static
    {
        $this->availabilities->removeElement($availability);

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        $this->equipments->removeElement($equipment);

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
            $booking->setLocation($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getLocation() === $this) {
                $booking->setLocation(null);
            }
        }

        return $this;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(?User $ofUser): static
    {
        $this->ofUser = $ofUser;

        return $this;
    }
}
