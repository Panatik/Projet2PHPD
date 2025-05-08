<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($r = 0; $r <= 8; $r++) {
            $reg = (new Registration());
            $reg->setRegistrationDate()
            ->setStatus()
            ->setPlayer($this->getReference('USER'.$r))
            ->setTournament($this->getReference('TOURNAMENT1'));
            $this->addReference('REGISTRATION'.$r, $reg);
            $manager->persist($reg);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [UserFixtures::class, TournamentFixtures::class];
    }
}
