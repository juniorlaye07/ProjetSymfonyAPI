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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class UtilisateurController extends AbstractController
{
//=============================Login====================================£=========================================================================================//
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

        $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
        $user->setRoles(["ROLE_SUPER_ADMIN"]);
        $user->setImageFile($Files);

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
            'massage' => 'L"utilisateur été bien ajouté'
        ];
        return new JsonResponse($data, 201);
    }
//====================Ajouter utilisateur==================================£========================================================================================================================£
    /**
     * @Route("/utilisateur", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {

        $values = json_decode($request->getContent());
        $profil = "";
        if (!empty($values->username)&& !empty($values->password)&& (strlen($values->password)<8)&& !empty($values->nom)&& !empty($values->prenom)&&
        !empty($values->tel)&& (strlen($values->tel)==9)&& !empty($values->status)){
            $user = new Utilisateur();
                $user->setUsername($values->username);
                $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            $profil = $values->profil;
            switch ($profil) {
                case 1:
                    $user->setRoles(['ROLE_ADMIN']);
                    $user->setStatus($values->status);
                    $repo = $this->getDoctrine()->getRepository(Partenaire::class);
                    $parten = $repo->find($values->partenaire);
                    $user->setPartenaire($parten);
                    break;
                case 2:
                    $user->setRoles(['ROLE_CAISIER']);
                    $user->setStatus($values->status);
                    break;
                case 3:
                    $user->setRoles(['ROLE_USER']);
                    $user->setStatus($values->status);
                    $repo = $this->getDoctrine()->getRepository(Partenaire::class);
                    $parten = $repo->find($values->partenaire);
                    $user->setPartenaire($parten);
                    break;
                default:
                    $data = [
                        'statuts' => 400,
                        'message' => 'Ce profil n\'existe pas,veillez réctifier votre profil!'
                    ];
                    return new JsonResponse($data, 400);
            }
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setTel($values->tel);

            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'statuts' => 201,
                'message' => 'L\'utilisateur a été bien enregistrer!'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            'statut' => 500,
            'messag' => 'Veillez bien vérifier les informations saisis!'
        ];
        return new JsonResponse($data, 500);
    }
    //========================bloquer utilisateur========================£===============================================================================================//
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
