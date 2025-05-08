<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SportMatch extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($m = 0; $m <= 7; $m++) {
            $match = (new SportMatch());
            $match->setMatchDate()
            ->setScorePlayer1()
            ->setScorePlayer2()
            ->setStatus()
            ->setTournament()
            ->setPalyer1()
            ->setPlayer2();
            $this->addReference('SPORTMATCH'.$m, $match);
            $manager->persist($match);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [UserFixtures::class, TournamentFixtures::class];
    }
}
