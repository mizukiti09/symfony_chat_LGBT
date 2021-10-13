<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $look;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=Contribute::class, mappedBy="user")
     */
    private $contributes;

    /**
     * @ORM\OneToMany(targetEntity=Bord::class, mappedBy="contribute_user")
     */
    private $bords;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="to_user")
     */
    private $messages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getLook(): ?string
    {
        return $this->look;
    }

    public function setLook(string $look): self
    {
        $this->look = $look;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function __construct()
    {
        $this->isActive = true;
        $this->contributes = new ArrayCollection();
        $this->bords = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        if($this->username == 'admin'){
            return array('ROLE_ADMIN');
        } else {
            return array('ROLE_USER');
        }
    }

    public function eraseCredentials()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ) = unserialize($serialized, array('allowed_classes'
          => false ));
    }

    /**
     * @return Collection|Contribute[]
     */
    public function getContributes(): Collection
    {
        return $this->contributes;
    }

    public function addContribute(Contribute $contribute): self
    {
        if (!$this->contributes->contains($contribute)) {
            $this->contributes[] = $contribute;
            $contribute->setUser($this);
        }

        return $this;
    }

    public function removeContribute(Contribute $contribute): self
    {
        if ($this->contributes->removeElement($contribute)) {
            // set the owning side to null (unless already changed)
            if ($contribute->getUser() === $this) {
                $contribute->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bord[]
     */
    public function getBords(): Collection
    {
        return $this->bords;
    }

    public function addBord(Bord $bord): self
    {
        if (!$this->bords->contains($bord)) {
            $this->bords[] = $bord;
            $bord->setContributeUser($this);
        }

        return $this;
    }

    public function removeBord(Bord $bord): self
    {
        if ($this->bords->removeElement($bord)) {
            // set the owning side to null (unless already changed)
            if ($bord->getContributeUser() === $this) {
                $bord->setContributeUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setToUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getToUser() === $this) {
                $message->setToUser(null);
            }
        }

        return $this;
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }
}
