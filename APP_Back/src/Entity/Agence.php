<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
* @ORM\Entity(repositoryClass=AgenceRepository::class)
* @ApiResource(
* attributes={"security"="is_granted('ROLE_ADMIN')", 
*             "security_message"="Seul un admin peut faire cette action.",
*             "normalization_context"={"groups"={"agence_detail_read", "agence_read"}},
*             "denormalization_context"={"groups"={"agence_detail_write", "agence_write"}}
*            },
*     collectionOperations={
*         "post"={ "path"="user/agences"},
*         "get"={"path"="user/agences"}
*     },
*     
*     itemOperations={
*         "get"={"path"="user/agences/{id}"}, 
*         "put"={"path"="user/agences/{id}"}
*  }
* )
*/


class Agence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"agence_detail_read", "agence_read", "agence_detail_write", "agence_write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agence_detail_read", "agence_read"})
     * @Groups({"agence_detail_write", "user_write"})
     * 
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agence_detail_read", "agence_read"})
     * @Groups({"agence_detail_write", "agence_write"})
     * 
     * 
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agence_detail_read", "agence_read"})
     * @Groups({"agence_detail_write", "agence_write"})
     * 
     * 
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     * @Groups({"agence_detail_read", "agence_read"})
     * @Groups({"agence_detail_write", "agence_write"})
     * 
     * 
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"agence_detail_read", "agence_read"})
     * @Groups({"agence_detail_write", "agence_write"})
     * 
     * 
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agence")
     * @Groups({"agence_detail_read", "agence_read"})
     * @Groups({"agence_detail_write", "agence_write"})
     * 
     * 
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"agence_detail_write", "agence_write"})
     * 
     */
    private $statut=true;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

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
            $user->setAgence($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAgence() === $this) {
                $user->setAgence(null);
            }
        }

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
}
