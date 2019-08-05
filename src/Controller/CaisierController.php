<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Utilisateur;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/** 
 * @Route("/api/caisier")
 */
class CaisierController extends AbstractController
{
    //=============Faire un dépot d'argent===========================£================================================================//
    /**
     * @Route("/depotcompte", name="depot", methods={"POST"})
     * @IsGranted("ROLE_CAISIER",message="Acces Refusé !")
     */
    public function FaireDepot(Request $request,  EntityManagerInterface $entityManager)
    {

        $values = json_decode($request->getContent());
        $numCompte = "";
        $repo = "";
        $caisier = "";

        if (isset($values->montant)) {
            $depo = new Depot();
            $depo->setDateDepot(new \DateTime());
            $depo->setMontant($values->montant);
            if (($values->montant) >= "75000") {


                $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
                $caisier = $repo->find($values->caisier);
                $depo->setCaisier($caisier);
                $repo = $this->getDoctrine()->getRepository(Compte::class);


                $numCompte = $repo->findOneBy(['numero_compte' => $values->numeroCompte]);

                $depo->setNumeroCompte($numCompte);

                $numCompte->setSolde($numCompte->getSolde() + $values->montant);

                $entityManager->persist($numCompte);

                $entityManager->persist($depo);
                $entityManager->flush();

                $data = [
                    'stat' => 201,
                    'msg' => 'Le depot  a été bien enregistré !'
                ];
                return new JsonResponse($data, 201);
            } else {

                $data = [
                    'status' => 400,
                    'message' => 'Le montant de votre dépot est insuffisant !'
                ];
                return new JsonResponse($data, 400);
            }
        }

        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner tous les champs,s\'il vous plait!'
        ];
        return new JsonResponse($data, 500);
    }
    //==========================================================>Juniorlaye07<============================================================================================//
}
