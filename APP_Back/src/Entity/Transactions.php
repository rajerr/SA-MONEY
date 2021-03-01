<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionsRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
* @ORM\Entity(repositoryClass=TransactionsRepository::class)
* @ApiResource(
* attributes={
*             "normalization_context"={"groups"={"transaction_detail_read", "transaction_read"}},
*             "denormalization_context"={"groups"={"transaction_detail_read", "transaction_read"}}
*            },
*     collectionOperations={
*         "recharger_compte"={ 
*                             "method"="post",
*                             "path"="user/transactions/recharge",
*                             "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CAISSIER')",
*                             "security_message"="Vous n'etes pas autorié"
*                             },
*         "transaction"={
*                             "method"="post",
*                             "path"="user/transactions",
*                             "security"="is_granted('ROLE_ADMINAGENCE') or is_granted('ROLE_USERAGENCE')",
*                             "security_message"="Vous n'etes pas autorié"
*                             },
*         "get_transaction"={
*                             "method"="get",
*                             "path"="user/transactions",
*                             "security"="is_granted('ROLE_ADMIN')",
*                             "security_message"="Vous n'etes pas autorié"
*                             },
*     },
*     
*     itemOperations={
*         "getTransaction_id"={
*                           "method"="get",
*                           "path"="user/transactions/{id}", 
*                           "security"="is_granted('ROLE_ADMINAGENCE') or is_granted('ROLE_USERAGENCE')",
*                           "security_message"="Vous n'etes pas autorié"
*                             },
*         "put_transaction"={
*                           "method"="put",
*                           "path"="user/transactions/{id}", 
*                           "security"="is_granted('ROLE_ADMINAGENCE') or is_granted('ROLE_USERAGENCE')",
*                           "security_message"="Vous n'etes pas autorié"
*                           },
*         "getTansactions _agence"={
*                           "method"="get",
*                           "path"="user/transactions/agence", 
*                           "security"="is_granted('ROLE_ADMINAGENCE')",
*                           "security_message"="Vous n'etes pas autorié" 
*                            },
*         "getTansactions _user_agence"={
*                           "method"="get",
*                           "path"="user/transactions/useragence", 
*                           "security"="is_granted('ROLE_ADMINAGENCE' && object.agence === user.agence)",
*                           "security_message"="Vous n'etes pas autorié" 
*                           }
*  }
* )
 */
class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $codeTrans;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $nomCompletEmet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $numeroCni;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $telephoneEmet;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $montantEnvoye;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $frais;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $fraisSysteme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $nomCompletBenef;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $telephoneBenef;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $montantRetire;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $dateEnvoie;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $typeTransaction;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactions")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeTrans(): ?string
    {
        return $this->codeTrans;
    }

    public function setCodeTrans(string $codeTrans): self
    {
        $this->codeTrans = $codeTrans;

        return $this;
    }

    public function getNomCompletEmet(): ?string
    {
        return $this->nomCompletEmet;
    }

    public function setNomCompletEmet(string $nomCompletEmet): self
    {
        $this->nomCompletEmet = $nomCompletEmet;

        return $this;
    }

    public function getNumeroCni(): ?string
    {
        return $this->numeroCni;
    }

    public function setNumeroCni(string $numeroCni): self
    {
        $this->numeroCni = $numeroCni;

        return $this;
    }

    public function getTelephoneEmet(): ?string
    {
        return $this->telephoneEmet;
    }

    public function setTelephoneEmet(string $telephoneEmet): self
    {
        $this->telephoneEmet = $telephoneEmet;

        return $this;
    }

    public function getMontantEnvoye(): ?int
    {
        return $this->montantEnvoye;
    }

    public function setMontantEnvoye(int $montantEnvoye): self
    {
        $this->montantEnvoye = $montantEnvoye;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(int $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(int $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(int $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSysteme(): ?int
    {
        return $this->fraisSysteme;
    }

    public function setFraisSysteme(int $fraisSysteme): self
    {
        $this->fraisSysteme = $fraisSysteme;

        return $this;
    }

    public function getNomCompletBenef(): ?string
    {
        return $this->nomCompletBenef;
    }

    public function setNomCompletBenef(string $nomCompletBenef): self
    {
        $this->nomCompletBenef = $nomCompletBenef;

        return $this;
    }

    public function getTelephoneBenef(): ?string
    {
        return $this->telephoneBenef;
    }

    public function setTelephoneBenef(string $telephoneBenef): self
    {
        $this->telephoneBenef = $telephoneBenef;

        return $this;
    }

    public function getMontantRetire(): ?int
    {
        return $this->montantRetire;
    }

    public function setMontantRetire(int $montantRetire): self
    {
        $this->montantRetire = $montantRetire;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->typeTransaction;
    }

    public function setTypeTransaction(string $typeTransaction): self
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    public function getCompte(): ?Comptes
    {
        return $this->compte;
    }

    public function setCompte(?Comptes $compte): self
    {
        $this->compte = $compte;

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

}
