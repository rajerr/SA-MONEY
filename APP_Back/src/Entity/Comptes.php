<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComptesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
* @ORM\Entity(repositoryClass=ComptesRepository::class)
* @ApiResource(
* attributes={"security"="is_granted('ROLE_ADMIN')", 
*             "security_message"="Seul un admin peut faire cette action.",
*             "normalization_context"={"groups"={"compte_detail_read", "compte_read"}},
*             "denormalization_context"={"groups"={"compte_write", "compte_detail_write"}}
*            },
*     collectionOperations={
*         "post"={ "path"="user/comptes"},
*         "get"={"path"="user/comptes"}
*     },
*     
*     itemOperations={
*         "get"={"path"="user/comptes/{id}"}, 
*         "delete"={"path"="user/comptes/{id}"},
*         "put"={"path"="user/comptes/{id}"}
*  }
* )
*/

class Comptes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte_detail_read", "compte_read"})
     * @Groups({"compte_write", "compte_detail_write", "transaction_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte_detail_read", "compte_read"})
     * @Groups({"compte_write", "compte_detail_write"})
     * 
     */
    private $numeroCpte;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte_detail_read", "compte_read"})
     * @Groups({"compte_write", "compte_detail_write"})
     * 
     */
    public $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({"compte_detail_read", "compte_read"})
     * @Groups({"compte_write", "compte_detail_write"})
     * 
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $statut = true;


    /**
     * @ORM\OneToOne(targetEntity=Agence::class, cascade={"persist", "remove"})
     * @Groups({"compte_detail_read", "compte_read"})
     * @Groups({"compte_write", "compte_detail_write"})
     * 
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compte")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="compte")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $users;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCpte(): ?string
    {
        return $this->numeroCpte;
    }

    public function setNumeroCpte(string $numeroCpte): self
    {
        $this->numeroCpte = $numeroCpte;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }


    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * @return Collection|Transactions[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transactions $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCompte($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getCompte() === $this) {
                $transaction->setCompte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCompte($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompte() === $this) {
                $user->setCompte(null);
            }
        }

        return $this;
    }
}
