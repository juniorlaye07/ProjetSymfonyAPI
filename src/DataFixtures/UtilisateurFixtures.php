<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user = new Utilisateur();
        $user->setUsername('juniorlaye07');
        $password = $this->encoder->encodePassword($user, 'junior07');
        $user->setPassword($password);
        $user->setRoles(['ROLE_SUPER_ADMINSYSTEME']);
        $user->setPrenom('Abdoulaye');
        $user->setNom('Ngom');
        $user->setTel('776418887');
        $user->setImageName('Api1.jpeg');
        $user->setUpdatedAt(new \DateTime);
        $manager->persist($user);
        $manager->flush();

        $caisier = new Utilisateur();
        $caisier->setUsername('safia');
        $password = $this->encoder->encodePassword($caisier, 'safia');
        $caisier->setPassword($password);
        $caisier->setRoles(['ROLE_CAISIER']);
        $caisier->setPrenom('Maman');
        $caisier->setNom('Ndour');
        $caisier->setTel('777941094');
        $caisier->setStatus('Actif');
        $caisier->setImageName('Api2.JPG');
        $caisier->setUpdatedAt(new \DateTime);
      
        $manager->persist($caisier);
        $manager->flush();
    }
}
