<?php

namespace App\Controller;

use App\Repository\ComptesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionController extends AbstractController
{
    /**
     * @Route(
     *     path="api/user/transactions/code", 
     *     methods={"put"}
     * )
     */
    public function getTransactionByCode(Request $request, TransactionsRepository $transrepos)
    {
        $data = json_decode($request->getContent(),true);
        $transaction = $transrepos->findOneBy(['codeTrans'=>$data["codeTrans"]]);

        return $this->json($transaction,Response::HTTP_OK);
    }


    /** 
    * @Route(
    *     path="api/user/transactions/agence", 
    *     methods={"get"}
    * )
    */
       public function getTansactionsAgence(TransactionsRepository $transrepos, Security $currentUser)
       {
           $agence = $currentUser->getUser()->getCompte()->getId();
           $data = $transrepos->findAll();
           $transactions = [];
           for ($i=1; $i <count($data); $i++) { 
               if ($data[$i]->getCompte()->getId() == $agence && $data[$i]->getTypeTransaction() != "recharge") {
                   $transactions[] = $data[$i];
               }
           }
           return $this->json($transactions);
       }


    /** 
    * @Route(
    *     path="api/user/transactions/useragence", 
    *     methods={"get"}
    * )
    */
    public function getTansactionsUser(TransactionsRepository $transrepos, Security $currentUser)
    {
        $user = $currentUser->getUser()->getId();
           $data = $transrepos->findAll();
           $transactions = [];
           for ($i=1; $i <count($data); $i++) { 
               if ($data[$i]->getUser()->getId() == $user) {
                   $transactions[] = $data[$i];
               }
           }
           return $this->json($transactions);
    }


    /** 
    * @Route(
    *     path="api/user/transactions/annuler", 
    *     methods={"put"}
    * )
    */
    public function annuletTransaction(Request $request,Security $currentUser, TransactionsRepository $transactionsRepos, ComptesRepository $compteRepos, EntityManagerInterface $manager){
      $data = json_decode($request->getContent(),true);
      $code = $data['codeTrans'];
      $agence = $currentUser->getUser()->getAgence();
      $transaction = $transactionsRepos->findOneBy(['codeTrans'=>$code]);
      // dd($transaction);
      $statut = $transaction->getStatut();
      $annuler = $transaction->getAnnuler();
      if ($code && $statut === false) {
        $transaction->setAnnuler(true);
        $compteAnnuler = $compteRepos->getCompte($agence->getId());
        // dd($compteAnnuler->getSolde());
        $compteAnnuler->setSolde($compteAnnuler->getSolde() - $transaction->getMontantRetire() - $transaction->getFraisDepot());
        // dd($data);
        $manager->persist($compteAnnuler);
        $manager->persist($transaction);
        $manager->flush();

        return  $this->json('votre transaction a été annuler');
      }
         
  }
}