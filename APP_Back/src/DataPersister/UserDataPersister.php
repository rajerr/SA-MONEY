<?php
namespace App\DataPersister;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    private $encoder;
    public function __construct(
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }
    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        $password = $data->getPassword();
        $data->setPassword($this->encoder->encodePassword($data, $password));
        $data->setStatut(true);
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
        $this->manager->persist($data);
    }
}