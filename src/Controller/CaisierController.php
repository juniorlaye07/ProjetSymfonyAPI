<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Utilisateur;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("is_granted('ROLE_CAISIER')",message="Veillez vous connecter en tant que Caisier!")
     */
    public function FaireDepot(Request $request,  EntityManagerInterface $entityManager)
    {

        $values = json_decode($request->getContent());
        $numCompte = "";
        $repo = "";
        $caisier = "";

        if (!empty($values->montant)&&(($values->montant) >= "75000")) {
            $depo = new Depot();
            $depo->setDateDepot(new \DateTime());
            $depo->setMontant($values->montant);
            


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
        }

        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner tous les champs et votre montant est insuffisant!'
        ];
        return new JsonResponse($data, 500);
    }
    //==========================================================>Juniorlaye07<============================================================================================//
}
