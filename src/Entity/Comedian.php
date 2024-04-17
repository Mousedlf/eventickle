<?php

namespace App\Entity;

use App\Repository\ComedianRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ComedianRepository::class)]
class Comedian
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['indexComedians', 'comedian:read'])]
    private ?int $id = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'comedians')]
    #[Groups(['comedian:read'])]
    private Collection $events;

    #[ORM\Column(length: 255)]
    #[Groups(['indexComedians', 'comedian:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['indexComedians', 'comedian:read'])]
    private ?string $surname = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['comedian:read'])]
    private ?array $links = null;

    /**
     * @var Collection<int, Spectator>
     */
    #[ORM\ManyToMany(targetEntity: Spectator::class, inversedBy: 'comedians')]
    #[Groups(['comedian:read'])]
    private Collection $followers;

    /**
     * @var Collection<int, Availability>
     */
    #[ORM\ManyToMany(targetEntity: Availability::class, inversedBy: 'comedians')]
    private Collection $availabilities;

    /**
     * @var Collection<int, Like>
     */
    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'comedian', orphanRemoval: true)]
    #[Groups(['comedian:read'])]
    private Collection $likes;

    #[ORM\OneToOne(inversedBy: 'comedian', cascade: ['persist', 'remove'])]
    #[Groups(['comedian:read'])]
    private ?Image $profilePicture = null;

    /**
     * @var Collection<int, Invite>
     */
    #[ORM\OneToMany(targetEntity: Invite::class, mappedBy: 'sentToComedian')]
    private Collection $receivedInvites;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['indexComedians', 'comedian:read'])]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'comedian', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->receivedInvites = new ArrayCollection();
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
            $event->addComedian($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            $event->removeComedian($this);
        }

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getLinks(): ?array
    {
        return $this->links;
    }

    public function setLinks(?array $links): static
    {
        $this->links = $links;

        return $this;
    }

    /**
     * @return Collection<int, Spectator>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(Spectator $follower): static
    {
        if (!$this->followers->contains($follower)) {
            $this->followers->add($follower);
        }

        return $this;
    }

    public function removeFollower(Spectator $follower): static
    {
        $this->followers->removeElement($follower);

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
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setComedian($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getComedian() === $this) {
                $like->setComedian(null);
            }
        }

        return $this;
    }

    public function getProfilePicture(): ?Image
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?Image $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

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
            $receivedInvite->setSentToComedian($this);
        }

        return $this;
    }

    public function removeReceivedInvite(Invite $receivedInvite): static
    {
        if ($this->receivedInvites->removeElement($receivedInvite)) {
            // set the owning side to null (unless already changed)
            if ($receivedInvite->getSentToComedian() === $this) {
                $receivedInvite->setSentToComedian(null);
            }
        }

        return $this;
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
