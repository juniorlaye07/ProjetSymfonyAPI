<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Compte;
use App\Entity\Partenaire;
use App\Entity\Utilisateur;
use App\Form\PartenaireType;
use App\Form\UtilisateurType;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("api/")
 */
class PartenaireController extends AbstractController
{
    /**
    * @Route("contrat", name="contrat", methods={"GET"})
    */
    public function Contrat(){

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('partenaire/index.html.twig', [
            'partenaire' => "Contrat de Prestation"
        ]);
       
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("contratprestataire.pdf", [
            "Attachment" => false
        ]);
      
        return new Response("Le fichier PDF a été bien générer !");
   
    }
//=======================================>Ajouter un partenaire<====================================£========================================================================================// 
    /**
     * @Route("partenaire", name="partenaire", methods={"POST"})
     * @IsGranted({"ROLE_SUPER_ADMINSYSTEME","ROLE_ADMINSYSTEME"},message="Acces Refusé! Veillez vous connecter en tant qu'administrateur systeme.")
     */
    public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
//===========================================>Enregistrer un Prestataire<=====================================£==============================================================//
            $parten = new Partenaire();

            $form = $this->createForm(PartenaireType::class, $parten);
            $form->handleRequest($request);
            $Values = $request->request->all();
            $form->submit($Values);
          
            $entityManager->persist($parten);
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
        $comptebank->setSolde('0');
        $comptebank->setPartenaire($parten);

        $entityManager->persist($comptebank);
        $entityManager->flush();

 //=================================>l'administrateur du préstataire<=======================£================================================================//
            $user = new Utilisateur();
            $form = $this->createForm(UtilisateurType::class, $user);
            $form->handleRequest($request);
            $Values = $request->request->all();
            $form->submit($Values);
            $Files = $request->files->all()['imageName'];

            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
            $user->setRoles(["ROLE_SUPER_ADMINPRESTA"]);
            $user->setImageFile($Files);
            $user->setPartenaire($parten);
            $user->setNumeroCompte($code);

        $errors = $validator->validate($user);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Typ' => 'applicatio/json'
            ]);
        }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        $data = [
            'statuts' => 201,
            'message' => 'Le prestataire a été bien créé!'
        ];
        return new JsonResponse($data, 201);

    }
//=============================================>Bloquer un partenaire<========================£======================================================================================================//
    /**
     * @Route("partenaire/{id}", name="updatparten", methods={"PUT"})
     * @IsGranted({"ROLE_SUPER_ADMINSYSTEME","ROLE_ADMINSYSTEME"},message="Acces Refusé! Veillez vous connecter en tant qu'administrateur systeme.")
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
     * @Route("listParten", name="prestas", methods={"GET"})
     * @IsGranted({"ROLE_SUPER_ADMINSYSTEME","ROLE_ADMINSYSTEME"},message="Acces Refusé! Veillez vous connecter en tant qu'administrateur systeme.")
     */
    public function show(PartenaireRepository $partenRepository, SerializerInterface $serializer)
    {
        $parten = $partenRepository->findAll();
        var_dump($parten);die();
        $data = $serializer->serialize($parten, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
//==============================================>Créer un compte Partenaire<=================================================================//
    /**
     * @Route("compte", name="compte", methods={"POST"})
     * @IsGranted({"ROLE_SUPER_ADMINSYSTEME","ROLE_ADMINSYSTEME","ROLE_CAISIER"},message="Acces Refusé! Veillez vous connecter en tant qu'administrateur systeme ou caisier.")
     */
    public function Compte(Request $request,  EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        if (!empty($values->ninea)) {
        
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
        $parten = $repo->findOneBy(['ninea' => $values->ninea]);
        $comptebank->setPartenaire($parten);

        $entityManager->persist($comptebank);
        $entityManager->flush();
        $data = [
            'statuts' => 201,
            'message' => 'Le compte a été bien créer!'
        ];
        return new JsonResponse($data, 201);
        }
        $data = [
            'statut' => 400,
            'messag' => 'Le solde initial du compte doit etre égale à 0 !'
        ];
        return new JsonResponse($data);
    }
}
//======================================================================>Juniorlaye07<=================================================================================//
