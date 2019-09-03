<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/api")
 */
class UtilisateurController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    //===================================================>Login<==============================£===============================================================================================//
    /**
     * @Route("/login", name="login", methods={"POST"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request,JWTEncoderInterface $JWTEncoder)
    {
        $values = json_decode($request->getContent());
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['username' => $values->username]);

        if (!$user) {
            return $this->createNotFoundException('Nom d\'Utilisateur incorrect');
        }
        $isValid = $this->passwordEncoder->isPasswordValid($user, $values->password);
        if (!$isValid) {
            return new BadCredentialsException();
        }
        //===============================================================================
        $profil=$this->getUser()->getRoles();
        $statuser =  $this->getUser()->getStatus();
       
       

          if (!empty($statuser) && $profil!=['ROLE_CAISIER']) {

                    $partenstat = $this->getUser()->getPartenaire()->getStatut();

                    if ($partenstat == 1) {
                        $data = [
                            'stat' => 400,
                            'messge' => 'Accés refusé! votre prestataire a été bloqué.'
                        ];
                        return new JsonResponse($data, 400);
                    }
                    if ($partenstat == 0 && $statuser == 1) 
                    {
                
                        $data = [
                            'stat' => 400,
                            'mesge' => 'Votre accés est bloqué,veillez vous adressez à votre administrateur!'
                        ];
                        return new JsonResponse($data, 400);
                    } 
                    else
                    {
                        $token = $JWTEncoder->encode([
                            'username'=>$user->getUsername(),
                            'roles'=>$user->getRoles(),
                            'partenaire'=>$user->getPartenaire(),
                            'id'=>$user->getId(),
                            
                            'exp'=> time() + 3600 // 1 hour expiration
                        ]);

                        return new JsonResponse(['token' => $token]);
                    }
        }
        else if( $profil==['ROLE_CAISIER']) 
        {

            if( $statuser == 1)
            {
                $data = [
                    'stat' => 400,
                    'mesge' => 'Votre accés est refusé! Veillez vous adressez à votre administrateur!'
                ];
                return new JsonResponse($data, 400);
            }
            else
            {
               $token = $JWTEncoder->encode([
                'username'=>$user->getUsername(),
                'roles'=>$user->getRoles(),
                'id'=> $user->getId(),
                'partenaire'=>$user->getPartenaire(),
                'exp'=> time() + 3600 // 1 hour expiration
            ]);
            return new JsonResponse(['token' => $token]);
            }
        }
        else
        {
            $token = $JWTEncoder->encode([
                'username'=>$user->getUsername(),
                'roles'=>$user->getRoles(),
                'partenaire'=>$user->getPartenaire(),
                'id'=>$user->getId(),
                'exp'=> time() + 3600 // 1 hour expiration
            ]);
            return new JsonResponse(['token' => $token]);
        }
    }
    //=====================================>Formulaire d'ajout Utilisateur<===================£==============================================================================//
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
        $user->setStatus(0);
        $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
        
       
        $profil = $Values['profil'];
        
        switch ($profil) {
            case 1:
                $user->setRoles(['ROLE_ADMINSYSTEME']);
                break;
            case 2:
                $user->setRoles(['ROLE_CAISIER']);
                break;
            case 3:
                $user->setRoles(['ROLE_ADMINPRESTA']);
                $parten = $this->getUser()->getPartenaire();
                $user->setPartenaire($parten);
                break;
            case 4:
                $user->setRoles(['ROLE_USER']);
                 $parten = $this->getUser()->getPartenaire();
                 $user->setPartenaire($parten);
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
                'Content-Typ' => 'applicatio/json'
            ]);
        }
        $data = [
            'stat' => 201,
            'massage' => 'Votre utilisateur a été bien enregistrer'
        ];
        return new JsonResponse($data, 201);
    }
    //==================================>Listes des utilisateurs<===================£=========================================================================================//
    /**
     * @Route("/listusers/{id}", name="listUser", methods={"GET"})
    */
    public function listuser(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {                            
        $colect= $entityManager->getRepository(Utilisateur::class);
        $user=$colect->findAll();
        $Objetjson = $serializer->serialize($user,'json',[
            'circular_reference_handler' => function ($Obj){
                return $Obj->getId();
            }
        ]) ;                                
        return new Response($Objetjson, 200, ['Content-Typ' => 'applicatio/json']);
    }


    //========================Bloquer un utilisateur========================£===============================================================================================//
    /**
     * @Route("/utilisateur/{id}", name="utilisaUpdate", methods={"PUT"})
    */
    // public function updat(Request $request, SerializerInterface $serializer, Utilisateur $user, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    // {
    //     $utilisaUpdate = $entityManager->getRepository(Utilisateur::class)->find($user->getId());
    //     $data = json_decode($request->getContent());
    //     foreach ($data as $key => $values) {
    //         if ($key && !empty($values)) {
    //             $status = ucfirst($key);
    //             $setter = 'set' . $status;
    //             $utilisaUpdate->$setter($values);
    //         }
    //     }
    //     $errors = $validator->validate($utilisaUpdate);
    //     if (count($errors)) {
    //         $errors = $serializer->serialize($errors, 'json');
    //         return new Response($errors, 500, [
    //             'Content-Type' => 'application/json'
    //         ]);
    //     }
    //     $entityManager->flush();
    //     $data = [
    //         'statu' => 200,
    //         'messag' => 'Le statuts de l\'utilisateur a été mis à jour'
    //     ];
    //     return new JsonResponse($data);
    // }
    public function bloqueDebloqueUser(Request $request, EntityManagerInterface $mng, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id]);
        if ($user->getIsActive()) {
            $user->setIsActive(false);
        } else {
            $user->setIsActive(true);
        }
        $mng = $this->getDoctrine()->getManager();
        $mng->persist($user);
        $mng->flush();
        $data = [
            'status' => 200,
            'message' => 'Le téléuser a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }
    //=========================================>Allouer un compte à User<=========================£============================================================================//
    /**
     * @Route("/UpdateCompte/{id}", name="Update", methods={"PUT"})
    */
    public function alouerCompte(Request $request, SerializerInterface $serializer, Utilisateur $user, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $parten = $this->getUser()->getPartenaire();
        $compte = $parten->getComptes();
        $numero = $compte[0]->getNumeroCompte();
        
        foreach ($compte as $values)
        {
            if (!empty($values)&& $values->getNumeroCompte()!= $numero)
            {
               $numero_compte = $values->getNumeroCompte();
            }
            break;
        }
        $CompteUpdate = $entityManager->getRepository(Utilisateur::class)->find($user->getId());
        $user->setNumeroCompte($numero_compte);
        
        $errors = $validator->validate($CompteUpdate);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'statut' => 200,
            'messag' =>'Un compte a été bien allouer à votre utilisateur'
        ];
        return new JsonResponse($data);
    }
    //============================================================================>Juniorlaye07<==========================================================================//
}

