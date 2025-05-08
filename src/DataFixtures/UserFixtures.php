<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = (new User());
        $admin->setEmail('admin@example.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword($this->hasher->hashPassword($admin,'admin'))
        ->setLastName('dutroux')
        ->setFirstName('michel')
        ->setUsername('admin')
        ->setStatus('actif');
        $this->addReference('ADMIN', $admin);
        $manager->persist($admin);

        for ($p = 0; $p <= 8; $p++) {
            $player = (new User());
            $player->setEmail('user'.$p.'@example.com')
            ->setRoles(['ROLE_PLAYER'])
            ->setPassword($this->hasher->hashPassword($player,'user'.$p))
            ->setLastName('last_name'.$p)
            ->setFirstName('Pierre')
            ->setUsername('user'.$p)
            ->setStatus('actif');
            $manager->persist($player);
            $this->addReference('USER'.$p, $player);
        }

        $manager->flush();
    }
}
