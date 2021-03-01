<?php
namespace App\DataPersister;

use App\Entity\Comptes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CompteDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    public function __construct(
        EntityManagerInterface $manager
    ) {
        $this->manager = $manager;
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Comptes;
    }
    /**
     * @param Comptes $data
     */
    public function persist($data, array $context = [])
    {

        $solde = $data->getSolde();
        if($solde>=700000){
            $data->setSolde($solde);
        }
        else{
            return new JsonResponse("Le montant a initialisé doit être superieur à 700 000", Response::HTTP_BAD_REQUEST, [], true);
        }
        $data ->setNumeroCpte(strtoupper(uniqid("CMP_SA_M_")));
        $data -> setDateCreation(new \DateTime('now'));
        $data -> setStatut(true);
        $this->manager->persist($data);
        $this->manager->flush();

        return $data;
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