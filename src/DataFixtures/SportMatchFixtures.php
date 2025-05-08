<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tournament;
use App\Entity\SportMatch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SportMatchFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($m = 0; $m <= 7; $m++) {
            $match = (new SportMatch());
            $match->setMatchDate(new \DateTime('04/21/1944'))
            ->setScorePlayer1(42)
            ->setScorePlayer2(69)
            ->setStatus("pending")
            ->setTournament($this->getReference('TOURNAMENT1', Tournament::class))
            ->setPalyer1($this->getReference('USER1', User::class))
            ->setPlayer2($this->getReference('USER2', User::class));
            $this->addReference('SPORTMATCH'.$m, $match);
            $manager->persist($match);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [UserFixtures::class,TournamentFixtures::class];
    }
}
