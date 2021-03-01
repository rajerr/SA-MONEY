<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity(repositoryClass=UserRepository::class)
* @ApiResource(
* attributes={"security"="is_granted('ROLE_ADMIN')", 
*             "security_message"="Seul un admin peut faire cette action.",
*             "normalization_context"={"groups"={"user_detail_read", "user_read"}},
*             "denormalization_context"={"groups"={"user_detail_write", "user_write"}},
*            },
*     collectionOperations={
*         "post"={ "path"="user/users"},
*         "get"={"path"="user/users"}
*     },
*     
*     itemOperations={
*         "get"={"path"="user/users/{id}"}, 
*         "delete"={"path"="user/users/{id}"},
*         "put"={"path"="user/users/{id}"}
*  }
* )
*/

class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_detail_read", "user_read", "profile_detail_read", "profile_read", "agence_detail_read", "agence_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     */
    private $username;

    /**
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user_detail_write", "user_write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     * 
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     * 
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     * 
     */
    private $telephone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     * 
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="users")
     * @Groups({"user_detail_read", "user_read","user_detail_write", "user_write"})
     * 
     * 
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users")
     * @Groups({"user_detail_write", "user_write", "user_detail_read", "user_read"})
     * 
     */
    private $agence;

    /**
     * @ORM\OneToMany(targetEntity=Transactions::class, mappedBy="user")
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity=Comptes::class, inversedBy="users")
     * @Groups({"user_detail_write", "user_write","user_detail_read", "user_read"})
     * 
     */
    private $compte;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_' . $this->profile->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

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
            $transaction->setUser($this);
        }

        return $this;
    }

    public function removeTransaction(Transactions $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getUser() === $this) {
                $transaction->setUser(null);
            }
        }

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
