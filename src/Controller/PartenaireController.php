<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/super")
 */
class PartenaireController extends AbstractController
{
//=======================================>Ajouter un partenaire<====================================£========================================================================================// 
    /**
     * @Route("/partenaire", name="partenaire", methods={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN",message="Acces Refusé !")
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {

        $values = json_decode($request->getContent());

        if (isset($values->ninea, $values->raisonSocial, $values->username, $values->password)) {
//=================================>l'administrateur du préstataire<=======================£================================================================//
            $user = new Utilisateur();
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));

            $profil = $values->profil;
            if ($profil == ['ROLE_ADMIN']) {
                $user->setRoles($profil);
            } else {
                $data = [
                    'stat' => 400,
                    'mesg' => 'Ce profil n\'existe pas'
                ];
                return new JsonResponse($data, 400);
            }
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setTel($values->tel);
            $user->setStatus($values->status);


            $entityManager->persist($user);
            $entityManager->flush();
            //=======================================>le compte associe au préstataire<====================================£==============================================================//
            $comptebank = new Compte();
            $code = "";
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $heure = date('H');
            $minutes = date('i');
            $seconde = date('s');
            $code = ($annee . $mois . $jour . $heure . $minutes . $seconde);

            $comptebank->setNumeroCompte($code);
            $comptebank->setSolde($values->solde);

            $entityManager->persist($comptebank);
            $entityManager->flush();
//===========================================>Enregistrer un Prestataire<=====================================£==============================================================//
            $parten = new Partenaire();

            $parten->setNinea($values->ninea);
            $parten->setAdresse($values->adresse);
            $parten->setRaisonSocial($values->raisonSocial);
            $parten->setEmail($values->email);
            $parten->setTel($values->telephone);
            $parten->setStatus($values->statut);
            $parten->addUtilisateur($user);
            $parten->addCompte($comptebank);

            $entityManager->persist($parten);
            $entityManager->flush();

            $data = [
                'statuts' => 201,
                'message' => 'Le prestataire a été bien créé!'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'statut' => 500,
            'messag' => 'Vous devez renseigner les champs manquants!'
        ];
        return new JsonResponse($data, 500);
    }

    //=============================================>Bloquer un partenaire<========================£======================================================================================================//
    /**
     * @Route("/partenaire/{id}", name="updatparten", methods={"PUT"})
     * @IsGranted("ROLE_SUPER_ADMIN",message="Acces Refusé !")
     */
    public function update(Request $request, SerializerInterface $serializer, Partenaire $parten, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $partenUpdate = $entityManager->getRepository(Partenaire::class)->find($parten->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value) {
            if ($key && !empty($value)) {
                $status = ucfirst($key);
                $setter = 'set' . $status;
                $partenUpdate->$setter($value);
            }
        }
        $errors = $validator->validate($partenUpdate);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'statut' => 200,
            'messag' => 'Le statuts du partenaire a été modifier'
        ];
        return new JsonResponse($data);
    }
//========================================>Lister les Partenaires<============================£========================================================================//
    /**
     * @Route("/listParten", name="listpartenaire", methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN",message="Acces Refusé !")
     */
    public function listParten(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        $partenaires = $partenaireRepository->findAll();
        $data = $serializer->serialize($partenaires, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
    /**
     * @Route("/compte", name="compte", methods={"POST"})
     * @IsGranted("ROLE_SUPER_ADMIN",message="Acces Refusé !")
     */
    public function Compte(Request $request,  EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (isset($values->solde)) {
        
        $comptebank = new Compte();
        $code = "";
        $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $minutes = date('i');
        $seconde = date('s');
        $code = ($annee . $mois . $jour . $heure . $minutes . $seconde);

        $comptebank->setNumeroCompte($code);
        $comptebank->setSolde('0');
        $repo = $this->getDoctrine()->getRepository(Partenaire::class);
        $parten = $repo->find($values->partenaire);
        $comptebank->setPartenaire($parten);

        $entityManager->persist($comptebank);
        $entityManager->flush();
        $data = [
            'statuts' => 201,
            'message' => 'Le compte a été bien créer!'
        ];
        return new JsonResponse($data, 201);
        }
    }
}
//======================================================================>Juniorlaye07<=================================================================================//
