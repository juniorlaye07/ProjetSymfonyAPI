<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



 class UserFixtures extends Fixture
{
    private $encoder;

public function __construct(UserPasswordEncoderInterface $encoder)
{
    $this->encoder = $encoder;
}

    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('juniorlaye07');
        $password = $this->encoder->encodePassword($user, 'junior07');
        $user->setPassword($password);
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setNom('Ngom');
        $user->setPrenom('Abdoulaye');
        $user->setTelephone('776418887');
        $user->setStatus('');
        $user->setImageName('Api2.JPG');
        $user->setUpdatedAt(new \DateTime());
        
        
        $manager->persist($user);
        $manager->flush();

        $caisier = new User();
        $caisier->setUsername('safia');
        $password = $this->encoder->encodePassword($user, 'safia');
        $caisier->setPassword($password);
        $caisier->setRoles(['ROLE_CAISIER']);
        $caisier->setNom('Ndour');
        $caisier->setPrenom('Safiètou');
        $caisier->setTelephone('777941094');
        $caisier->setStatus('Actif');
        $caisier->setImageName('Api2.JPG');
        $caisier->setUpdatedAt(new \DateTime());
        
        $manager->persist($caisier);
        $manager->flush();
    }
}
