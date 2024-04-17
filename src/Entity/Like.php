<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Comedian $comedian = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComedian(): ?Comedian
    {
        return $this->comedian;
    }

    public function setComedian(?Comedian $comedian): static
    {
        $this->comedian = $comedian;

        return $this;
    }
}
