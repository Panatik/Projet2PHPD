<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tournament;
use App\Entity\Registration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegistrationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($r = 0; $r <= 8; $r++) {
            $reg = (new Registration());
            $reg->setRegistrationDate(new \DateTime('04/21/1944'))
            ->setStatus('confirmed')
            ->setPlayer($this->getReference('USER'.$r, User::class))
            ->setTournament($this->getReference('TOURNAMENT1', Tournament::class));
            $this->addReference('REGISTRATION'.$r, $reg);
            $manager->persist($reg);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [UserFixtures::class,TournamentFixtures::class];
    }
}
