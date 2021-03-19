<?php
namespace App\DataPersister;

use Twilio\Rest\Client;
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
            $data->setTypeTransaction('Depot');
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

            $agence = $this->currentUser->getUser()->getAgence();
            $compte = $this->compteRepos->getCompte($agence->getId());

            if ($data->getTypeTransaction() == "Depot" & $data->getMontantEnvoye()< $compte->getSolde()) {
                $compte->setSolde(($compte->getSolde()-$data->getMontantEnvoye())+ $fraisDepot);
                $compte->setDateCreation(new \DateTime('now'));

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
                     ->setUser($this->currentUser->getUser())
                     ->setStatut(false)
                     ->setAnnuler(false);

                $sid = "AC01ffe2ceb9e87dc5fe55ef320fa26436" ; // Votre compte SID de www.twilio.com/console 
                $token = "0d6379ba6c368ef4f08656f412064468" ; // Votre jeton d'authentification de www.twilio.com/console 
                // $client = new  Twilio \Rest\Client ( $sid , $token );
                $twilio = new Client($sid, $token);
                $message = $twilio -> messages -> create (
                '+221784654636' ,// Textez ce numéro 
                [ 'from' => '+12702015769' , // D'un numéro Twilio valide 
                    'body' => 'Votre envoie de: '.$mntenvoie.' a été effectué avec succes. le $codeTrans de transaction. montant à rétirer mtnRetire' 
                ] 
                ); 
                $this->manager->persist($data);
                $this->manager->flush();
            }
            if ($data->getTypeTransaction() == "Depot" && $data->getMontantEnvoye()< $compte->getSolde()) {
                return new JsonResponse('Votre solde ne vous permet pas de faire le depot');
                
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
                $statut = $transaction->getStatut();
                $annuler = $transaction->getAnnuler();
                    if ($code && $statut === false && $annuler ===false) {
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
                        ->setFraisRetrait($fraisRetrait)
                        ->setStatut(true)
                        ->setAnnuler(false);
                    $compteRetrait = $this->compteRepos->getCompte($agence->getId());
                    $compteRetrait->setSolde($compteRetrait->getSolde() + $transaction->getMontantRetire() + $fraisRetrait);
                    $compteRetrait->setDateCreation(new \DateTime('now'));
                    $transaction->setStatut(1);

                    $sid = "AC01ffe2ceb9e87dc5fe55ef320fa26436" ; // Votre compte SID de www.twilio.com/console 
                    $token = "0d6379ba6c368ef4f08656f412064468" ; // Votre jeton d'authentification de www.twilio.com/console 
                    $twilio = new Client($sid, $token);
                    $message = $twilio -> messages -> create (
                    '+221784654636' ,// Textez ce numéro 
                    [ 'from' => '+12702015769' , // D'un numéro Twilio valide 
                        'body' => 'Votre Retrait de: '.$mntenvoie.' a été effectué avec succes. le code transaction'.$code.'  montant retiré '.$mtnRetire.'FCFA. le '
                    ] 
                    ); 
                    $this->manager->persist($data);
                    $this->manager->persist($compteRetrait);
                    $this->manager->persist($transaction);
                    $this->manager->flush();                
                }
                else{
                    return new JsonResponse("errro de traitement", Response::HTTP_BAD_REQUEST, [], true);
                }
            }

            return $data;
        }
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