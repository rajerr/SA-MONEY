<?php
namespace App\DataPersister;


use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class AgenceDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Agence;
    }
    /**
     * @param Agence $data
     */
    public function persist($data, array $context = [])
    {
        if ($errors){
            $errors = $serializer->serialize($errors, "json");
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }
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
    }
}