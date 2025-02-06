<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Computer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Computer $computer = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $endTime = null;

    // Add the setComputer method
    public function setComputer(Computer $computer): self
    {
        $this->computer = $computer;

        return $this;
    }

    // Add the getComputer method
    public function getComputer(): ?Computer
    {
        return $this->computer;
    }

    // Add the setUser method
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    // Add the getUser method
    public function getUser(): ?User
    {
        return $this->user;
    }

    // Getters and setters for other properties...
}
