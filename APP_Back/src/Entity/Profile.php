<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
* @ORM\Entity(repositoryClass=ProfileRepository::class)
* @ApiResource(
*   attributes={"security"="is_granted('ROLE_ADMIN')",
*               "security_message"="Seul un admin peut faire cette action.", 
*               "normalization_context"={"groups"={"profile_detail_read", "profile_read"}}
*               },
*     collectionOperations={
*         "post"={ "path"="user/profiles"},
*         "get"={"path"="user/profiles"}
*     },
*     
*     itemOperations={
*         "get"={"path"="user/profiles/{id}"}, 
*         "delete"={"path"="user/profiles/{id}"},
*         "put"={"path"="user/profiles/{id}"}
*  }
* )
*/

class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profile_detail_read", "profile_read" , "user_read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profile_detail_read", "profile_read" , "user_read"})
     * 
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profile")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $user->setProfile($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfile() === $this) {
                $user->setProfile(null);
            }
        }

        return $this;
    }
}
