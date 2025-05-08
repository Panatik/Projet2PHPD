<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Tournament;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class TournamentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $tourney = (new Tournament());
        $tourney->setTournamentName("Biche Volley Tribe Champions")
        ->setStartDate(new \DateTime('04/21/1944'))
        ->setEndDate(new \DateTime('04/21/1944'))
        ->setLocation('Plage')
        ->setDescription("Tournoi de biche volley avec comme récompense un repas à l'hippopotamouth")
        ->setMaxParticipants(8)
        ->setSport('Biche Volley')
        ->setOrganizer($this->getReference('ADMIN', User::class))
        ->setWinner($this->getReference('USER5', User::class));
        $this->addReference('TOURNAMENT1', $tourney);
        $manager->persist($tourney);

        $manager->flush();
    }

    public function getDependencies(): array {
        return [UserFixtures::class,];
    }
}
