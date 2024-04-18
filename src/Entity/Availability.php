<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
class Availability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['establishment:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['establishment:read'])]
    private array $dates = [];

    #[ORM\Column(nullable: true)]
    #[Groups(['establishment:read'])]
    private ?int $capacity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['establishment:read'])]
    private ?string $description = null;

    /**
     * @var Collection<int, Comedian>
     */
    #[ORM\ManyToMany(targetEntity: Comedian::class, mappedBy: 'availabilities')]
    private Collection $comedians;

    /**
     * @var Collection<int, Establishment>
     */
    #[ORM\ManyToMany(targetEntity: Establishment::class, mappedBy: 'availabilities')]
    private Collection $establishments;

    public function __construct()
    {
        $this->comedians = new ArrayCollection();
        $this->establishments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function setDates(array $dates): static
    {
        $this->dates = $dates;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): static
    {
        $this->capacity = $capacity;

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
            $comedian->addAvailability($this);
        }

        return $this;
    }

    public function removeComedian(Comedian $comedian): static
    {
        if ($this->comedians->removeElement($comedian)) {
            $comedian->removeAvailability($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Establishment>
     */
    public function getEstablishments(): Collection
    {
        return $this->establishments;
    }

    public function addEstablishment(Establishment $establishment): static
    {
        if (!$this->establishments->contains($establishment)) {
            $this->establishments->add($establishment);
            $establishment->addAvailability($this);
        }

        return $this;
    }

    public function removeEstablishment(Establishment $establishment): static
    {
        if ($this->establishments->removeElement($establishment)) {
            $establishment->removeAvailability($this);
        }

        return $this;
    }
}
