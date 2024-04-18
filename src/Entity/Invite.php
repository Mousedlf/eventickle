<?php

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: InviteRepository::class)]
class Invite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['establishment:read', 'invitation:read'])]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'receivedInvites')]
    private ?Establishment $sentToEstablishment = null;


    #[ORM\ManyToOne(inversedBy: 'receivedInvites')]
    private ?Comedian $sentToComedian = null;

    #[ORM\ManyToOne(inversedBy: 'sentInvites')]
    #[Groups(['establishment:read', 'invitation:read'])]
    private ?ComedyClub $comedyClub = null;

    #[ORM\ManyToOne(inversedBy: 'invites')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['invitation:read'])]
    private ?Event $event = null;

    #[ORM\Column]
    private ?int $status = null;

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }
    
}
