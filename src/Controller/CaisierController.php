<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\DepotType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/** 
 * @Route("/api")
 */
class CaisierController extends AbstractController
{
//=============Faire un dépot d'argent===========================£================================================================//
    /**
     * @Route("/depotcompte", name="depot", methods={"POST"})
    */
   
//==========================================================>Juniorlaye07<============================================================================================//
    public function FaireDepot(Request $request,  EntityManagerInterface $entityManager)
    {
     $depot = new Depot();    
     $idc=$this->getUser();
     $form = $this->createForm(DepotType::class, $depot);
     $form->handleRequest($request);
     $Values =$request->request->all();
     $form->submit($Values);
     $depot->setDateDepot(new \DateTime());
     $depot->setCaisier($idc);
     $montant=$Values['montant'];
     $depot->setMontant($montant);
     $numeroCompt=$Values['Numero'];
     $repo = $this->getDoctrine()->getRepository(Compte::class);
     $numcompt = $repo->findOneBy(['numero_compte'=>$numeroCompt]);
     $depot->setNumeroCompte($numcompt);
     $numcompt->setSolde($numcompt->getSolde() + $montant);
    
    
    if($montant<"75000") {
        $data = [
            'status' => 500,
            'mesage' =>"Le montant minimum autorisé est de 75000 fr",
        ];

        return new JsonResponse($data, 500);
    } 
    else {
       
    $entityManager->persist($numcompt);

    $entityManager->persist($depot);
    $entityManager->flush();

    $data = [
        'status_1' => 201,
        'message' => 'Le depot  a été bien enregistré !',
    ];

    return new JsonResponse($data, 201);

    }
    $data = [
        'status' => 500,
        'message' => 'Vous devez renseigner tous les champs et votre montant est insuffisant!'
    ];
        return new JsonResponse($data, 500);
  }
}
