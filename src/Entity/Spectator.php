<?php

namespace App\Entity;

use App\Repository\SpectatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpectatorRepository::class)]
class Spectator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['comedy-club:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, Comedian>
     */
    #[ORM\ManyToMany(targetEntity: Comedian::class, mappedBy: 'followers')]
    private Collection $followedComedians;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'boughtBy', orphanRemoval: true)]
    private Collection $boughtTickets;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'spectator', orphanRemoval: true)]
    private Collection $tickets;

    #[ORM\OneToOne(inversedBy: 'spectator', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    public function __construct()
    {
        $this->followedComedians = new ArrayCollection();
        $this->boughtTickets = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

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
     * @return Collection<int, Comedian>
     */
    public function getFollowedComedians(): Collection
    {
        return $this->followedComedians;
    }

    public function addFollowedComedian(Comedian $comedian): static
    {
        if (!$this->followedComedians->contains($comedian)) {
            $this->followedComedians->add($comedian);
            $comedian->addFollower($this);
        }

        return $this;
    }

    public function removeFollowedComedian(Comedian $comedian): static
    {
        if ($this->followedComedians->removeElement($comedian)) {
            $comedian->removeFollower($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getBoughtTickets(): Collection
    {
        return $this->boughtTickets;
    }

    public function addBoughtTicket(Ticket $boughtTicket): static
    {
        if (!$this->boughtTickets->contains($boughtTicket)) {
            $this->boughtTickets->add($boughtTicket);
            $boughtTicket->setBoughtBy($this);
        }

        return $this;
    }

    public function removeBoughtTicket(Ticket $boughtTicket): static
    {
        if ($this->boughtTickets->removeElement($boughtTicket)) {
            // set the owning side to null (unless already changed)
            if ($boughtTicket->getBoughtBy() === $this) {
                $boughtTicket->setBoughtBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setSpectator($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getSpectator() === $this) {
                $ticket->setSpectator(null);
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
