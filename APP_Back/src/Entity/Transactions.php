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
*             "normalization_context"={"groups"={"transaction_detail_read", "transaction_read"}}
*            },
*     collectionOperations={
*         "post"={ "path"="user/transactions"},
*         "get"={"path"="user/transactions"}
*     },
*     
*     itemOperations={
*         "get"={"path"="user/transactions/{id}"}, 
*         "put"={"path"="user/transactions/{id}"}
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $code_trans;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $nom_complet_emet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $numero_cni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $telephone_emet;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $montant_envoye;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $frais_depot;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $frais_retrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $frais_etat;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $frais_systeme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $nom_complet_benef;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $telephone_benef;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $montant_retire;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $date_envoie;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $date_retrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $type_transaction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_detail_read", "transaction_read"})
     * 
     */
    private $statut_tansaction;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="transactions")
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeTrans(): ?string
    {
        return $this->code_trans;
    }

    public function setCodeTrans(string $code_trans): self
    {
        $this->code_trans = $code_trans;

        return $this;
    }

    public function getNomCompletEmet(): ?string
    {
        return $this->nom_complet_emet;
    }

    public function setNomCompletEmet(string $nom_complet_emet): self
    {
        $this->nom_complet_emet = $nom_complet_emet;

        return $this;
    }

    public function getNumeroCni(): ?string
    {
        return $this->numero_cni;
    }

    public function setNumeroCni(string $numero_cni): self
    {
        $this->numero_cni = $numero_cni;

        return $this;
    }

    public function getTelephoneEmet(): ?string
    {
        return $this->telephone_emet;
    }

    public function setTelephoneEmet(string $telephone_emet): self
    {
        $this->telephone_emet = $telephone_emet;

        return $this;
    }

    public function getMontantEnvoye(): ?int
    {
        return $this->montant_envoye;
    }

    public function setMontantEnvoye(int $montant_envoye): self
    {
        $this->montant_envoye = $montant_envoye;

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
        return $this->frais_depot;
    }

    public function setFraisDepot(int $frais_depot): self
    {
        $this->frais_depot = $frais_depot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->frais_retrait;
    }

    public function setFraisRetrait(int $frais_retrait): self
    {
        $this->frais_retrait = $frais_retrait;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->frais_etat;
    }

    public function setFraisEtat(int $frais_etat): self
    {
        $this->frais_etat = $frais_etat;

        return $this;
    }

    public function getFraisSysteme(): ?int
    {
        return $this->frais_systeme;
    }

    public function setFraisSysteme(int $frais_systeme): self
    {
        $this->frais_systeme = $frais_systeme;

        return $this;
    }

    public function getNomCompletBenef(): ?string
    {
        return $this->nom_complet_benef;
    }

    public function setNomCompletBenef(string $nom_complet_benef): self
    {
        $this->nom_complet_benef = $nom_complet_benef;

        return $this;
    }

    public function getTelephoneBenef(): ?string
    {
        return $this->telephone_benef;
    }

    public function setTelephoneBenef(string $telephone_benef): self
    {
        $this->telephone_benef = $telephone_benef;

        return $this;
    }

    public function getMontantRetire(): ?int
    {
        return $this->montant_retire;
    }

    public function setMontantRetire(int $montant_retire): self
    {
        $this->montant_retire = $montant_retire;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->date_envoie;
    }

    public function setDateEnvoie(\DateTimeInterface $date_envoie): self
    {
        $this->date_envoie = $date_envoie;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->date_retrait;
    }

    public function setDateRetrait(?\DateTimeInterface $date_retrait): self
    {
        $this->date_retrait = $date_retrait;

        return $this;
    }

    public function getTypeTransaction(): ?string
    {
        return $this->type_transaction;
    }

    public function setTypeTransaction(string $type_transaction): self
    {
        $this->type_transaction = $type_transaction;

        return $this;
    }

    public function getStatutTansaction(): ?string
    {
        return $this->statut_tansaction;
    }

    public function setStatutTansaction(string $statut_tansaction): self
    {
        $this->statut_tansaction = $statut_tansaction;

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

}
