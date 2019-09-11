<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Form\UserType;
use App\Form\DepotType;
use App\Form\ComptBanType;
use App\Entity\Partenaires;
use App\Form\PartenaireType;
use App\Entity\ComptBancaire;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/api")
 */
class AdminSystemController extends FOSRestController
{
  
     /**
     * @Route("/partenaire", name="super", methods={"POST","GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function admin(Request $request, SerializerInterface $serializer,UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager,ValidatorInterface $validator)
    {

     //=======================Ajout Partenaire==============================//  
        
         $code=0;
         $jour = date('d');
         $mois = date('m');
         $annee = date('Y');
         $heure = date('H');
         $minutes = date('i');
         $seconde = date('s');
         $code = ($annee.$mois.$jour.$heure.$minutes.$seconde);
         
     $partenaire =new Partenaires();  
    
     $form = $this->createForm(PartenaireType::class, $partenaire);
     $form->handleRequest($request);
     $Values =$request->request->all();
     $form->submit($Values);
     $partenaire->setStatut('Actif');
     $entityManager->persist($partenaire);

        //======================= creer Admin du partenaire====================//
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $Values =$request->request->all();
        $form->submit($Values);
        $Files=$request->files->all()['imageName'];
        $user->setImageFile($Files);

        $user->setPassword($passwordEncoder->encodePassword($user,$form->get('plainPassword')->getData()));
        $user->setRoles(["ROLE_ADMIN_PRS"]);
        $user->setStatus('Actif');
        $user->setCompteBancaire($code);
        $user->setPartenaire($partenaire);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
             

 //============================creer un compte bancaire==================//      

            $compb = new ComptBancaire();
           
            $compb->setNumCompt($code);
            $compb->setSolde('0');
            $compb->setPartenaire($partenaire);

            $errors = $validator->validate($user);
            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Types' => 'applications/json'
                ]);
            } 
            $entityManager->persist($compb); 
            $entityManager->flush();
                
            
  
                $data =[
                    'STATUS' => 201,
                    'msg1' => 'Votre partenaire a été bien enregistrer!',
                ];
                return new JsonResponse($data, 201);

    }
//=====================================Lister Partenaires=====================================================
     /**
      * @Route("/listeParten/{id}", name="listePart", methods={"GET"})
      */
      public function listeuser(UserRepository $userRepo, SerializerInterface $serializer,EntityManagerInterface $entityManager)
      {
        
        $listUser= $entityManager->getRepository(Partenaires::class);
        $users = $listUser->findAll();
       
        $jsonObject = $serializer->serialize($users, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);

    }

//===========================================Créer un compte=======================================================
    /**
     * @Route("/compte", name="compte", methods={"POST"})
     */
    public function ajoutComptB(Request $request,EntityManagerInterface $entityManager)
    {
        $compb = new ComptBancaire();
     $form = $this->createForm(ComptBanType::class, $compb);
     $form->handleRequest($request);
     $Values =$request->request->all();
     $form->submit($Values);
           
            $code="";
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $heure = date('H');
            $minutes = date('i');
            $seconde = date('s');
            $code = ($annee . $mois . $jour . $heure . $minutes . $seconde);
            $compb->setNumCompt($code);
            $compb->setSolde('0');
            $ninea=$Values['ninea'];
            $repo = $this->getDoctrine()->getRepository(Partenaires::class);
            $partenaire = $repo->findOneBy(['ninea'=>$ninea]);
            $compb->setPartenaire($partenaire);
            
            $entityManager->persist($compb); 
            $entityManager->flush();
        $data = [
            'STATUT' => 201,
            'msg2' => 'Le compte de votre partenaire a été bien créer ',
        ];
        return new JsonResponse($data, 201);
    }
//================================================Faire un dépot=========================================================
    /**
     * @Route("/depot", name="depotfor", methods={"POST"})
     * @IsGranted("ROLE_CAISIER")
     */
    public function Depotav(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
     $depot = new Depot();    
     $form = $this->createForm(DepotType::class, $depot);
     $form->handleRequest($request);
     $Values =$request->request->all();
     $form->submit($Values);
     $depot->setDateDepot(new \DateTime());
     $depot->setCassier($this->getUser());
     $montant=$Values['montant'];
     $depot->setMontant($montant);
     $numeroCompt=$Values['Numero'];
     $repo = $this->getDoctrine()->getRepository(ComptBancaire::class);
     $numcompt = $repo->findOneBy(['numCompt'=>$numeroCompt]);
    //  $nom=$numcompt->getPartenaire();
     

     $depot->setNumeroCompt($numcompt);
    
    $numcompt->setSolde($numcompt->getSolde() + $montant);
    if($montant<"75000") {
        $data = [
            'status-0' => 500,
            'message-0' =>"Le montant de dépot minimum autorisée est de 75000 fr",
        ];

        return new JsonResponse($data, 500);
    } else{
    
  
    $entityManager->persist($numcompt);


    $entityManager->persist($depot);
    $entityManager->flush();

     
            $dat = $serializer->serialize($numcompt, 'json', [
                'groups' => ['listparten']
            ]);
            return new Response($dat, 200, [
                'Content-Type' => 'application/json'
            ]);
        }
    }
//========================================Bloquer utilisateur==================================================================
    /**
    * @Route("/BloqueUser/{id}", name="bloqueDebloqueUser", methods={"POST","GET"})
    */
    public function bloqueDebloqueUser(Request $request,EntityManagerInterface $mng,$id)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=>$id]);
        if ($user->getStatus()=='Actif') {
            $user->setStatus('Bloquer');
        }
        else {
            $user->setStatus('Actif');
        }
        $mng = $this->getDoctrine()->getManager();
        $mng->persist($user);
        $mng->flush();
        $data = [
            'status' => 200,
            'mesag12' => 'Le status a bien été mis à jour!'
        ];
        return new JsonResponse($data);
    }
//==============================================Bloquer Parten===================================================
    /**
    * @Route("/bloquerparten/{id}", name="bloquePart", methods={"POST","GET"})
    */
    public function bloqueDebloquePart(Request $request,EntityManagerInterface $mng,$id)
    {
        $part=$this->getDoctrine()->getRepository(Partenaires::class)->findOneBy(['id'=>$id]);
        $users=$part->getUsers();
        foreach ($users as $key => $value) {
            $this->bloqueDebloqueUser($request,$mng,$value->getId());
        }
        if($part->getStatut()=='Actif') {
            $part->setStatut('Bloquer');
        }
        else {
            $part->setStatut('Actif');
        }
        $mng= $this->getDoctrine()->getManager();
        $mng->persist($part);
        $mng->flush();
        $data = [
            'status' => 200,
            'messge10' => ' Le status de votre partenaire a bien été mis à jour !'
        ];
        return new JsonResponse($data);
    }
}
