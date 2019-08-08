<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class UtilisateurController extends AbstractController
{
//===================================================>Login<==============================£===============================================================================================//
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([

            'roles' => $user->getRoles(),
            'username' => $user->getUsername()
        ]);
    }
//=====================================>Formulaire d'ajout Utilisateur<=================£==============================================================================//
    /**
     * @Route("/form", name="form", methods={"POST","GET"})
     */
    public function addUtilisateur(Request $request, UserPasswordEncoderInterface $passwordEncoder, SerializerInterface $serializer, ValidatorInterface $validator){
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        $Values = $request->request->all();
        $form->submit($Values);
        $Files = $request->files->all()['imageName'];
        $user->setImageFile($Files);
        $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
       
        $profil = $Values['profil'];
        switch ($profil) {
            case 1:
                $user->setRoles(['ROLE_ADMIN_SYSTEME']);
                break;
            case 2:
                $user->setRoles(['ROLE_CAISIER']);
                break;
            case 3:
                $user->setRoles(['ROLE_ADMIN_PRESTA']);
                break;
            case 4:
                $user->setRoles(['ROLE_USER']);
                break;
            default:
                $data = [
                    'stat' => 400,
                    'messge' => 'Ce profil n\'existe pas,veillez réctifier votre profil!'
                ];
                return new JsonResponse($data, 400);
        }
       
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        
        $errors = $validator->validate($user);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $data = [
            'stat' => 201,
            'massage' => 'Votre utilisateur a été bien enregistrer'
        ];
        return new JsonResponse($data, 201);
    }
//========================Bloquer un utilisateur========================£===============================================================================================//
    /**
     * @Route("/utilisateur/{id}", name="utilisaUpdate", methods={"PUT"})
     */
    public function updat(Request $request, SerializerInterface $serializer, Utilisateur $user, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $utilisaUpdate = $entityManager->getRepository(Utilisateur::class)->find($user->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $values) {
            if ($key && !empty($values)) {
                $status = ucfirst($key);
                $setter = 'set' . $status;
                $utilisaUpdate->$setter($values);
            }
        }
        $errors = $validator->validate($utilisaUpdate);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'statut' => 200,
            'messag' => 'Le statuts de l\'utilisateur a été mis à jour'
        ];
        return new JsonResponse($data);
    }
    //============================================================================>Juniorlaye07<==========================================================================//
}
