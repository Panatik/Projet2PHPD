<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\Type(\DateTime::class)]
    private ?\DateTime $registrationDate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['confirmée', 'en attente'], message: "Statut invalide.")]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Le joueur est requis.")]
    private ?User $player = null;

    #[ORM\ManyToOne(targetEntity: Tournament::class, inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Le tournoi est requis.")]
    private ?Tournament $tournament = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationDate(): ?\DateTime
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTime $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): static
    {
        $this->player = $player;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }
}
