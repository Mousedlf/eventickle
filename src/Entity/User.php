<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'comedian:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user:read', 'comedian:read'])]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'ofUser', cascade: ['persist', 'remove'])]
    private ?Comedian $comedian = null;

    #[ORM\OneToOne(mappedBy: 'ofUser', cascade: ['persist', 'remove'])]
    private ?ComedyClub $comedyClub = null;

    #[ORM\OneToOne(mappedBy: 'ofUser', cascade: ['persist', 'remove'])]
    private ?Establishment $establishment = null;

    #[ORM\OneToOne(mappedBy: 'ofUser', cascade: ['persist', 'remove'])]
    private ?Spectator $spectator = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'madeBy', orphanRemoval: true)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getComedian(): ?Comedian
    {
        return $this->comedian;
    }

    public function setComedian(?Comedian $comedian): static
    {
        // unset the owning side of the relation if necessary
        if ($comedian === null && $this->comedian !== null) {
            $this->comedian->setOfUser(null);
        }

        // set the owning side of the relation if necessary
        if ($comedian !== null && $comedian->getOfUser() !== $this) {
            $comedian->setOfUser($this);
        }

        $this->comedian = $comedian;

        return $this;
    }

    public function getComedyClub(): ?ComedyClub
    {
        return $this->comedyClub;
    }

    public function setComedyClub(?ComedyClub $comedyClub): static
    {
        // unset the owning side of the relation if necessary
        if ($comedyClub === null && $this->comedyClub !== null) {
            $this->comedyClub->setOfUser(null);
        }

        // set the owning side of the relation if necessary
        if ($comedyClub !== null && $comedyClub->getOfUser() !== $this) {
            $comedyClub->setOfUser($this);
        }

        $this->comedyClub = $comedyClub;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): static
    {
        // unset the owning side of the relation if necessary
        if ($establishment === null && $this->establishment !== null) {
            $this->establishment->setOfUser(null);
        }

        // set the owning side of the relation if necessary
        if ($establishment !== null && $establishment->getOfUser() !== $this) {
            $establishment->setOfUser($this);
        }

        $this->establishment = $establishment;

        return $this;
    }

    public function getSpectator(): ?Spectator
    {
        return $this->spectator;
    }

    public function setSpectator(?Spectator $spectator): static
    {
        // unset the owning side of the relation if necessary
        if ($spectator === null && $this->spectator !== null) {
            $this->spectator->setOfUser(null);
        }

        // set the owning side of the relation if necessary
        if ($spectator !== null && $spectator->getOfUser() !== $this) {
            $spectator->setOfUser($this);
        }

        $this->spectator = $spectator;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setMadeBy($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getMadeBy() === $this) {
                $order->setMadeBy(null);
            }
        }

        return $this;
    }


}
