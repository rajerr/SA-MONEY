<?php
namespace App\DataPersister;

use App\Entity\Comptes;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CompteDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->_entityManager = $entityManager;
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
        return $data;
    }
    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $users=$data->getUsers();
        $this->_entityManager->persist($data);
        foreach ($users as $user ) {
            $user->setStatut(false);
            $this->_entityManager->persist($user);
        }
        $this->_entityManager->flush();
        
        return $data;
    }
}