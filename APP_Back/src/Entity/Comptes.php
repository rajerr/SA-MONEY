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
*             "normalization_context"={"groups"={"compte_detail_read", "compte_read"}}
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $numero_cpte;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $solde;

    /**
     * @ORM\Column(type="date")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comptes")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, cascade={"persist", "remove"})
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="compte")
     * @Groups({"compte_detail_read", "compte_read"})
     * 
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCpte(): ?string
    {
        return $this->numero_cpte;
    }

    public function setNumeroCpte(string $numero_cpte): self
    {
        $this->numero_cpte = $numero_cpte;

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
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
}
