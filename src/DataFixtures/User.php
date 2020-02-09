<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class User extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new Users();
        $user->setUsername('paczkow');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'ralf1996'
        ));
        $user->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_USER']);
        $user->setIsEnabled(true);
        $user->setFirstName('Marcin');
        $user->setLastName('Paczkowski');
        $manager->persist($user);
        $manager->flush();

    }
}

