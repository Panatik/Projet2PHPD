<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TournamentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $tourney = (new Tournament());
        $tourney->setTournamentName()
        ->setStartDate()
        ->setEndDate()
        ->setLocation()
        ->setDescription()
        ->setMaxParticipants()
        ->setSport()
        ->setOrganizer($this->getReference('ADMIN'))
        ->setWinner($this->getReference('USER5'));
        $this->addReference('TOURNAMENT1', $tourney);
        $manager->persist($tourney);

        $manager->flush();
    }

    public function getDependencies() {
        return [UserFixtures::class];
    }
}
