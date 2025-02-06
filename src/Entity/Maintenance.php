<?php

namespace App\Entity;

use App\Repository\MaintenanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Computer::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Computer $computer = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $maintenanceDate = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function getComputer(): ?Computer
    {
        return $this->computer;
    }

    public function setComputer(Computer $computer): self
    {
        $this->computer = $computer;
        return $this;
    }

    // Getters and setters...
}
