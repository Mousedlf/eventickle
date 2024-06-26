<?php

namespace App\Entity;

use App\Repository\ComedyClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ComedyClubRepository::class)]
class ComedyClub
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['comedian:read', 'establishment:read', 'comedy-club:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['comedian:read', 'establishment:read', 'comedy-club:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'comedyClub', orphanRemoval: true)]
    #[Groups(['comedy-club:read'])]
    private Collection $organizedEvents;

    /**
     * @var Collection<int, Invite>
     */
    #[ORM\OneToMany(targetEntity: Invite::class, mappedBy: 'comedyClub')]
    private Collection $sentInvites;

    #[ORM\OneToOne(inversedBy: 'comedyClub', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    public function __construct()
    {
        $this->organizedEvents = new ArrayCollection();
        $this->sentInvites = new ArrayCollection();
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

    /**
     * @return Collection<int, Event>
     */
    public function getOrganizedEvents(): Collection
    {
        return $this->organizedEvents;
    }

    public function addOrganizedEvent(Event $organizedEvent): static
    {
        if (!$this->organizedEvents->contains($organizedEvent)) {
            $this->organizedEvents->add($organizedEvent);
            $organizedEvent->setComedyClub($this);
        }

        return $this;
    }

    public function removeOrganizedEvent(Event $organizedEvent): static
    {
        if ($this->organizedEvents->removeElement($organizedEvent)) {
            // set the owning side to null (unless already changed)
            if ($organizedEvent->getComedyClub() === $this) {
                $organizedEvent->setComedyClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invite>
     */
    public function getSentInvites(): Collection
    {
        return $this->sentInvites;
    }

    public function addSentInvite(Invite $sentInvite): static
    {
        if (!$this->sentInvites->contains($sentInvite)) {
            $this->sentInvites->add($sentInvite);
            $sentInvite->setComedyClub($this);
        }

        return $this;
    }

    public function removeSentInvite(Invite $sentInvite): static
    {
        if ($this->sentInvites->removeElement($sentInvite)) {
            // set the owning side to null (unless already changed)
            if ($sentInvite->getComedyClub() === $this) {
                $sentInvite->setComedyClub(null);
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
