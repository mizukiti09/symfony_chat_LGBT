<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\BordRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BordRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Bord
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Contribute::class, inversedBy="bords" ,cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="contribute_id", referencedColumnName="id", nullable=false)
     */
    private $contribute;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bords", cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="contribute_user_id", referencedColumnName="id", nullable=false)
     */
    private $contribute_user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bords", cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $delete_flg;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="bord")
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContribute(): ?contribute
    {
        return $this->contribute;
    }

    public function setContribute(?contribute $contribute): self
    {
        $this->contribute = $contribute;

        return $this;
    }

    public function getContributeUser(): ?User
    {
        return $this->contribute_user;
    }

    public function setContributeUser(?User $contribute_user): self
    {
        $this->contribute_user = $contribute_user;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeleteFlg(): ?bool
    {
        return $this->delete_flg;
    }

    public function setDeleteFlg(?bool $delete_flg): self
    {
        $this->delete_flg = $delete_flg;

        return $this;
    }


    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTimeImmutable();
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
            $message->setBord($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getBord() === $this) {
                $message->setBord(null);
            }
        }

        return $this;
    }
}
