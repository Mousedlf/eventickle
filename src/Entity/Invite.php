<?php

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InviteRepository::class)]
class Invite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'receivedInvites')]
    private ?Establishment $sentToEstablishment = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'receivedInvites')]
    private ?Comedian $sentToComedian = null;

    #[ORM\ManyToOne(inversedBy: 'sentInvites')]
    private ?ComedyClub $comedyClub = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getSentToEstablishment(): ?Establishment
    {
        return $this->sentToEstablishment;
    }

    public function setSentToEstablishment(?Establishment $sentToEstablishment): static
    {
        $this->sentToEstablishment = $sentToEstablishment;

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

    public function getSentToComedian(): ?Comedian
    {
        return $this->sentToComedian;
    }

    public function setSentToComedian(?Comedian $sentToComedian): static
    {
        $this->sentToComedian = $sentToComedian;

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
}
