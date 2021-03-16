<?php
namespace App\DataPersister;

use App\Entity\Transactions;
use App\Services\FraisService;
use App\Repository\ComptesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionsRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class TransactionDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    private $currentUser;
    private $compteRepos;
    private $transactionRepos;
    private $frais;

    public function __construct(
        EntityManagerInterface $manager,
        Security $currentUser,
        ComptesRepository $compteRepos,
        TransactionsRepository $transactionRepos,
        FraisService $frais
    ) {
        $this->manager = $manager;
        $this->currentUser = $currentUser;
        $this->compteRepos = $compteRepos;
        $this->transactionRepos = $transactionRepos;
        $this->frais = $frais;
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Transactions;
    }
    /**
     * @param Transactions $data
     */
    public function persist($data, array $context = [])
    {
        if ($context['collection_operation_name']==="recharger_compte") {
            $compte = $data->getCompte();
            $compte->setSolde($compte->getSolde() + $data->getMontantEnvoye());
            $data->setDateEnvoie(new \DateTime('now'));
            $data->setTypeTransaction('Recharge');
            $data->setUser($this->currentUser->getUser());
            $this->manager->persist($data);
            $this->manager->persist($compte);
            $this->manager->flush();
        }

        if ($context['collection_operation_name']==="transaction") {
            $frais = $this->frais->getFrais($data->getMontantEnvoye());
            $fraisEtat = $frais*0.4;
            $fraisSysteme = $frais*0.3;
            $fraisDepot = $frais*0.1;
            $fraisRetrait = $frais*0.2;
            $mntenvoie = $frais + $data->getMontantEnvoye();
            $mtnRetire = $mntenvoie - $frais;
            if ($data->getTypeTransaction() == "Depot") {
                $agence = $this->currentUser->getUser()->getAgence();
                $compte = $this->compteRepos->getCompte($agence->getId());
                $compte->setSolde(($compte->getSolde()-$data->getMontantEnvoye())+ $fraisDepot);
                $data->setCodeTrans(random_int(1,1000000000))
                     ->setTypeTransaction('Depot')
                     ->setFrais($frais)
                     ->setFraisEtat($fraisEtat)
                     ->setFraisSysteme($fraisSysteme)
                     ->setFraisDepot($fraisDepot)
                     ->setMontantRetire($mtnRetire)
                     ->setCompte($compte)
                     ->setMontantEnvoye($mntenvoie)
                     ->setDateEnvoie(new \DateTime ('now'))
                     ->setUser($this->currentUser->getUser());
                $this->manager->persist($data);
                $this->manager->flush();

            }
            if ($data->getTypeTransaction() === "Retrait") {
                $code = $data->getCodeTrans();
                $agence = $this->currentUser->getUser()->getAgence();
                $transaction = $this->transactionRepos->findOneBy(['codeTrans'=>$code]);
                $user = $this->currentUser->getUser();
                $code = $transaction->getCodeTrans();
                $mntenvoie=$transaction->getMontantEnvoye();
                $mtnRetire = $transaction->getMontantRetire();
                $compte = $transaction->getCompte();
                $nomCompletEmet = $transaction->getNomCompletEmet();
                $telephoneEmet = $transaction->getTelephoneEmet();
                $nomCompletBenef = $transaction->getNomCompletBenef();
                $telephoneBenef = $transaction->getTelephoneBenef();
                $dateEnvoie = $transaction->getDateEnvoie();
                $frais = $transaction->getFrais();
                $fraisSysteme = $transaction->getFraisSysteme();
                $fraisEtat = $transaction->getFraisEtat();
                $fraisDepot = $transaction->getFraisDepot();
                if ($code) {
                   $data->setUser($user)
                        ->setCodeTrans($code)
                        ->setMontantEnvoye($mntenvoie)
                        ->setMontantRetire($mtnRetire)
                        ->setCompte($compte)
                        ->setNomCompletEmet($nomCompletEmet)
                        ->setTelephoneEmet($telephoneEmet)
                        ->setNomCompletBenef($nomCompletBenef)
                        ->setTelephoneBenef($telephoneBenef)
                        ->setDateEnvoie($dateEnvoie)
                        ->setDateRetrait(new \DateTime('now'))
                        ->setTypeTransaction('Retrait')
                        ->setFrais($frais)
                        ->setFraisSysteme($fraisSysteme)
                        ->setFraisEtat($fraisEtat)
                        ->setFraisDepot($fraisDepot)
                        ->setFraisRetrait($fraisRetrait);
                    $compteRetrait = $this->compteRepos->getCompte($agence->getId());
                    $compteRetrait->setSolde($compteRetrait->getSolde() + $transaction->getMontantRetire() + $fraisRetrait);
                    $this->manager->persist($data);
                    $this->manager->persist($compteRetrait);
                    $this->manager->flush();
                }
            }

            return $data;
        }
        
        // $solde = $data->getSolde();
        // if($solde>=700000){
        //     $data->setSolde($solde);
        // }
        // else{
        //     return new JsonResponse("Le montant a initialisé doit être superieur à 700 000", Response::HTTP_BAD_REQUEST, [], true);
        // }
        // $data ->setNumeroCpte(uniqid("CMP_SA_M_"));
        // $data -> setDateCreation(new \DateTime('now'));
        // $data -> setStatut(true);

        // $this->manager->persist($data);
        // $this->manager->flush();


    }
    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $agence=$data->getAgence();
        $agence->setStatut(false);
        $this->manager->persist($data);
        $this->manager->persist($agence);
        $users=$data->getUsers();
        foreach ($users as $user ) {
            $user->setStatut(false);
            $this->manager->persist($user);
        }
        return new JsonResponse("Un compte a été archivé", Response::HTTP_OK);
    }
}