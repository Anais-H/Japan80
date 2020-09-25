<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setPseudo('UserTest');
        $user->setEmail('user@symfony.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'the_new_password'
        ));
        $user->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus laoreet tortor vel luctus ornare. In dignissim arcu nec dictum luctus. Vivamus in mauris sit amet nisl ullamcorper lobortis non facilisis eros. Donec sodales enim bibendum, mollis quam vel, molestie velit. Sed sed nulla at ex aliquet aliquet quis sit amet nibh. Sed feugiat arcu nisl, non interdum mauris tincidunt eu. In eget lectus tempus, auctor libero a, vestibulum dolor. Maecenas dapibus arcu urna, vitae ornare odio sodales sed.');

        $manager->persist($user);

        $manager->flush();
    }
}
