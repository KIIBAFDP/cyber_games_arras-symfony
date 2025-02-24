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

    #[ORM\Column(length: 255)]
    private ?string $forfait = null;

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

    // Add the setStartTime method
    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;
        return $this;
    }

    // Add the getStartTime method
    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    // Add the setEndTime method
    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;
        return $this;
    }

    // Add the getEndTime method
    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    // Add the setForfait method
    public function setForfait(string $forfait): self
    {
        $this->forfait = $forfait;
        return $this;
    }

    // Add the getForfait method
    public function getForfait(): ?string
    {
        return $this->forfait;
    }
}
