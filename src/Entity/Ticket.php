<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'soldTickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'boughtTickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Spectator $boughtBy = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 2000)]
    private ?string $qrCode = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Spectator $spectator = null;

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
        $this->event = $event;

        return $this;
    }

    public function getBoughtBy(): ?Spectator
    {
        return $this->boughtBy;
    }

    public function setBoughtBy(?Spectator $boughtBy): static
    {
        $this->boughtBy = $boughtBy;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): static
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getSpectator(): ?Spectator
    {
        return $this->spectator;
    }

    public function setSpectator(?Spectator $spectator): static
    {
        $this->spectator = $spectator;

        return $this;
    }
}
