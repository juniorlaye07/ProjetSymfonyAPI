<?php

namespace App\Controller;

use App\Entity\Tarifs;
use App\Entity\Commission;
use App\Entity\Transaction;
use App\Entity\ComptBancaire;
use App\Entity\Retrait;
use App\Form\TransactionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/api")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/tra", name="transaction_index", methods={"GET"})
     */
    public function index(TransactionRepository $transactionRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("contratprestataire.pdf", [
            "Attachment" => false
        ]);
        // Send some text response
        return $this->render('admin_part/index.html.twig', [
            'controller_name' => 'AdminPartController',
        ]);
        //return new Response("Le fichier PDF a été bien générer !");

    }

    /**
     * @Route("/transaction", name="transaction_new", methods={"GET","POST"})
     */
    public function new(Request  $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $commi = new Commission();
        $transaction = new Transaction();
        $retrait=new Retrait();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);
        $Values = $request->request->all();
        $form->submit($Values);

         
         $part = $this->getUser()->getCompteBancaire();
         
         $repo = $this->getDoctrine()->getRepository(ComptBancaire::class);
         $numcompt = $repo->findOneBy(['numCompt' => $part]);
         $val = $numcompt->getSolde();
        
         $repo = $this->getDoctrine()->getRepository(Tarifs::class);
         $tar = $repo->findAll();
         
            $user = $this->getUser();

            $type = $Values['type'];
            
            if ($type == '1') {
                $montant = $Values['montant'];
                if ($montant < $val) {
                    foreach ($tar as $value) {
                        $min = $value->getBorneInferieur();
                        $max = $value->getBorneSuperieur();
                        if (($min <= $montant) && ($montant >= $max)) {
                            $com = $value->getValeur();
                        }
                    }
                $etat = ($com * 0.3);
                $envoye = ($com * 0.1);
                $comretrait = (($com * 20) / 100);
                $system = (($com * 40) / 100);
    
             $code = date('d') . date('m') . date('y') . date('s') . date('m');
             $transaction->setDateTrans(new \DateTime());
             $transaction->setUser($user);   
            

                $transaction->setMontant($montant);
                $transaction->setCodeTrans($code);
                $numcompt->setSolde($numcompt->getSolde() - $montant);
                $numcompt->setSolde($numcompt->getSolde() + $envoye);
                $transaction->setEnvoi('Envoye');

                $commi->setPartenaire($system);
                $commi->setEtat($etat);
                $commi->setEnvoi($envoye);
                $commi->setRetrait($comretrait);
                $commi->setDate(new \DateTime());
                $entityManager->persist($commi);
            }
                
         else {

            $data = [
                'STATUS' =>400,
                'MESSAGE' => 'votre sole ne vous permet pas deffectuer cette transaction',
            ];
            return new JsonResponse($data, 400);
        }
        $entityManager->persist($transaction);

    }
            if ($type == '2') {
                $coderetrait = $Values['code'];
                $cniB = $Values['cniB'];
                $repo = $this->getDoctrine()->getRepository(Transaction::class);
                $trans = $repo->findOneBy(['codeTrans'=> $coderetrait]);
                $coderetrait=$trans->getCodeTrans();
                $montantreti=$trans->getMontant();
                
                if($trans->getRetrait()=='Retrait'){
                    $data = [
                        'STATU' => 400,
                        'MESSAG' => 'Desoler ce code est deja utiliser ',
                    ];
                    return new JsonResponse($data, 400);
                }
                else{
                    foreach ($tar as $value) {
                        $min = $value->getBorneInferieur();
                        $max = $value->getBorneSuperieur();
                        if (($min <= $montantreti) && ($montantreti >= $max)) {
                            $com = $value->getValeur();
                        }
                    }
                $comretrait = (($com * 20) / 100);
    
                    $retrait->setTransaction($trans);
                    $retrait->setCode($coderetrait);     
                    $retrait->setDateRetrait(new \DateTime());
                    $retrait->setUser($user);
                    $entityManager->persist($retrait);

                    
                $numcompt->setSolde($numcompt->getSolde() + $montantreti);
                $numcompt->setSolde($numcompt->getSolde() + $comretrait);
                $trans->setRetrait('Retrait');
                $trans->setCniB($cniB);

                }
               
            }    

        $errors = $validator->validate($user);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();



        $data = [
            'STATUS' => 201,
            'MESSAGE' => 'La transaction a ete bien effectuer',
        ];
        return new JsonResponse($data, 201);
    
}

    /**
     * @Route("/listransac", name="show-transaction", methods={"GET"})
     */
    public function show(Request  $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $user=$this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(Transaction::class);
        $reposy = $this->getDoctrine()->getRepository(Retrait::class);

        $trans = $repo->findOneBy(['user'=> $user]);

        $tr = $reposy->findOneBy(['user' => $user]);

        if ($repo->findOneBy(['user' => $user])) {
            $dat = $serializer->serialize($trans, 'json', [
                'groups' => ['listTransac']
            ]);
        }
        if ($reposy->findOneBy(['user' => $user])) {
            $dat = $serializer->serialize($tr, 'json', [
                'groups' => ['listTransac']
            ]);
        }
        return new Response($dat, 200, [
            'Content-Type' => 'application/json'
        ]);

    }
}