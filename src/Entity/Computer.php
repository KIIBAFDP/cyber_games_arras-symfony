<?php

namespace App\Entity;

use App\Repository\ComputerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComputerRepository::class)]
class Computer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $processor = null;

    #[ORM\Column(length: 255)]
    private ?string $memory = null;

    #[ORM\Column(length: 255)]
    private ?string $os = null;

    #[ORM\ManyToMany(targetEntity: Game::class)]
    private Collection $installedGames;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastMaintenanceDate = null;

    public function __construct()
    {
        $this->installedGames = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(string $processor): self
    {
        $this->processor = $processor;
        return $this;
    }

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(string $memory): self
    {
        $this->memory = $memory;
        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(string $os): self
    {
        $this->os = $os;
        return $this;
    }

    public function getInstalledGames(): Collection
    {
        return $this->installedGames;
    }

    public function addInstalledGame(Game $game): self
    {
        if (!$this->installedGames->contains($game)) {
            $this->installedGames[] = $game;
        }

        return $this;
    }

    public function removeInstalledGame(Game $game): self
    {
        $this->installedGames->removeElement($game);

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;
        return $this;
    }

    public function getLastMaintenanceDate(): ?\DateTimeInterface
    {
        return $this->lastMaintenanceDate;
    }

    public function setLastMaintenanceDate(?\DateTimeInterface $lastMaintenanceDate): self
    {
        $this->lastMaintenanceDate = $lastMaintenanceDate;
        return $this;
    }
}
