<?php

namespace App\Entity;

use App\Repository\SportMatchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SportMatchRepository::class)]
class SportMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\Date]
    private ?\DateTime $matchDate = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $scorePlayer1 = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?int $scorePlayer2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(choices: ['en attente', 'en cours', 'terminé'])]
    private ?string $status = 'en attente';

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'sportMatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'player1')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?User $palyer1 = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'player2')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?User $player2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchDate(): ?\DateTime
    {
        return $this->matchDate;
    }

    public function setMatchDate(\DateTime $matchDate): static
    {
        $this->matchDate = $matchDate;

        return $this;
    }

    public function getScorePlayer1(): ?int
    {
        return $this->scorePlayer1;
    }

    public function setScorePlayer1(int $scorePlayer1): static
    {
        $this->scorePlayer1 = $scorePlayer1;

        return $this;
    }

    public function getScorePlayer2(): ?int
    {
        return $this->scorePlayer2;
    }

    public function setScorePlayer2(int $scorePlayer2): static
    {
        $this->scorePlayer2 = $scorePlayer2;

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

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }

    public function getPalyer1(): ?User
    {
        return $this->palyer1;
    }

    public function setPalyer1(?User $palyer1): static
    {
        $this->palyer1 = $palyer1;

        return $this;
    }

    public function getPlayer2(): ?User
    {
        return $this->player2;
    }

    public function setPlayer2(?User $player2): static
    {
        $this->player2 = $player2;

        return $this;
    }
}
