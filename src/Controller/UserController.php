<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Partenaires;
use App\Entity\CompBancaire;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
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
        $user= $this->getDoctrine()->getRepository(User::class)->findOneBy(['username'=>$values->username]);
        
        if (!$user) 
        {
            $dat = [
                'status0' => 400,
                'messages1' => 'Nom d\'Utilisateur incorrect'
            ];
            return new JsonResponse($dat, 400);
        }
        $isValid = $this->passwordEncoder->isPasswordValid($user,$values->password);
        if (!$isValid) 
        {

            $dat = [
                'status1' => 400,
                'messages2' => 'Mot de passe incorrect!'
            ];
            return new JsonResponse($dat, 400);
        }
  //===============================================================================
     
       $profil = $user->getRoles(); 
      
      
       if (!empty($user->getStatus()) && $profil!=['ROLE_CAISIER'] ) {
            $statuser = $user->getStatus();
       $partenstat =$user->getPartenaire()->getStatut();
       
       if ($partenstat =='Bloquer' && $profil==['ROLE_ADMIN_PRS']) 
       {
           $data = [
               'status3' => 400,
               'messages3' => 'Accés refusé! votre prestataire a été bloqué.'
           ];
           return new JsonResponse($data, 400);
       }
       elseif ($partenstat == 'Actif' &&  $statuser == 'Bloquer')
       {
           $data = [
               'status4' => 400,
               'messages4' => 'Votre accés est refusé,veillez vous adressez à votre administrateur!'
           ];
           return new JsonResponse($data, 400);
       }
       elseif($statuser == 'Bloquer'){
           $dat= [
               'status5' => 400,
               'messages5' => 'Votre accés est refusé,veillez vous adressez à votre administrateur!'
           ];
           return new JsonResponse($dat, 400);
       }
       else{
       $token = $JWTEncoder->encode([
           'username' => $user->getUsername(),
           'roles'=>$user->getRoles(),
           'partenaire'=>$user->getPartenaire(),
           'exp' => time() + 3600 // 1 hour expiration
       ]);
       return new JsonResponse(['token' => $token]);
       }
    }
       elseif($profil==['ROLE_CAISIER']) {
            $statuser = $user->getStatus();
        if ($statuser =='Bloquer') 
        {
            $data = [
                'status6' => 400,
                'messages6' => 'Accés refusé! votre status a été bloqué.'
            ];
            return new JsonResponse($data, 400);
        }
         
       else
       {
           $token = $JWTEncoder->encode([
               'username' => $user->getUsername(),
               'roles'=>$user->getRoles(),
               'exp' => time() + 3600 // 1 hour expiration
           ]);
           return new JsonResponse(['token' => $token]);
       }
    }
       
       else
       {
           $token = $JWTEncoder->encode([
               'username' => $user->getUsername(),
               'roles'=>$user->getRoles(),
               'exp' => time() + 36000 // 1 hour expiration
           ]);
           return new JsonResponse(['token' => $token]);
       }
    } 
//===========================================Enregistrer user=================================================
    /**
     * @Route("/form", name="user_new", methods={"GET","POST"})
     * @IsGranted({"ROLE_ADMIN_PRS","ROLE_SUPER_ADMIN"},message="vous netes pas autoriser a ajouter des utilisateur")
     */
    public function addUser(Request $request,UserPasswordEncoderInterface $passwordEncoder, SerializerInterface $serializer,ValidatorInterface $validator)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $Values =$request->request->all();
        $form->submit($Values);

    $Files=$request->files->all()['imageName'];
        $profil=$Values['profil'];
        switch ($profil) {
            case 1:
                $user->setRoles(['ROLE_ADMIN']);
                $parte=$this->getUser()->getPartenaire();
                $user->setPartenaire($parte);
                break;
            case 2:
                $user->setRoles(['ROLE_CAISIER']);
                break;
            case 3:
               
                $user->setRoles(['ROLE_USERs']);
                $parte=$this->getUser()->getPartenaire();
                $user->setPartenaire($parte);

                break;
            default:
                $data = [
                    'statuts7' => 400,
                    'messages7' => 'Ce profil n\'existe pas,veillez réctifier votre profil!'
                ];
                return new JsonResponse($data, 400);
        }
        
        $user->setPassword($passwordEncoder->encodePassword($user,$form->get('plainPassword')->getData()));
        $user->setStatus('Actif');      


        $user->setImageFile($Files);
            $entityManager = $this->getDoctrine()->getManager();
          $errors = $validator->validate($user);
                if(count($errors)) {
                    $errors = $serializer->serialize($errors, 'json');
                    return new Response($errors, 500, [
                        'Content-Typle' => 'applicatlion/json'
                    ]);
                } 
                $entityManager->persist($user);
                $entityManager->flush();
                $data = [
                  'statut8' => 201,
                  'massages8' => 'L\'utilisateur a été bien enregistrer!'
                ];
                return new JsonResponse($data, 201);

               
            }

//==============================================Allouer un compte=======================================================
    /**
     * @Route("/UpdateCompte/{id}", name="Allouer", methods={"PUT","GET"})
     * @IsGranted({"ROLE_ADMIN_PRS"},message="vous n'etes pas autoriser a ajouter des utilisateur")

     */
    public function allouerCompte(Request $request, SerializerInterface $serializer, User $user, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
       
        $adpart=$this->getUser();  
  
        $part=$adpart->getPartenaire();
        $compt=$part->getComptBancaires();
       $numero=$compt[0]->getNumCompt();
        foreach ($compt as $value) {
            if ($value->getNumCompt()!= $numero) {
              $newne=$value->getNumCompt();
                break;
            } 
        }
       
        $bloqueP = $entityManager->getRepository(User::class)->find($user->getId());
         $user->setCompteBancaire($newne);
        $errors = $validator->validate($bloqueP);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');

            return new Response($errors, 500, [
                'Content-Type' => 'application/json',
            ]);
        }
        $entityManager->flush();
        $data = [
            'status9' => 200,
            'messages9' => 'Votre compte a ete bien allouer à votre utilisateur!',
        ];

        return new JsonResponse($data);
    }
//============================================Liste Users=======================================================================
     /**
      * @Route("/listeUsers", name="listeUserr", methods={"GET"})
      */

    public function listeuser(Request  $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $usr = $this->getUser()->getRoles();
       
        $user = [];
        $repo = $this->getDoctrine()->getRepository(User::class);
        $trans = $repo->findAll();

        if ($usr == ['ROLE_ADMIN_PRS']) {
            foreach ($trans as $value) {

                if ($value->getRoles() == ['ROLE_USERs']) {
                    $user[] = $value;
                }
            }
        }else if ($usr == ['ROLE_SUPER_ADMIN']) {

            foreach ($trans as $value) {

                if ($value->getRoles() == ['ROLE_CAISIER']) {
                    $user[] = $value;
                }
            }
        }

        $dat = $serializer->serialize($user, 'json', [
            'groups' => ['listUsers']

        ]);


        return new Response($dat, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
