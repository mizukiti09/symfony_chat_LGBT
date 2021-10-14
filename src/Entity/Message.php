<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Message
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
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages" ,cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="to_user_id", referencedColumnName="id", nullable=false)
     */
    private $to_user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages" ,cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="from_user_id", referencedColumnName="id", nullable=false)
     */
    private $from_user;

    /**
     * @ORM\ManyToOne(targetEntity=Bord::class, inversedBy="messages",cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="bord_id", referencedColumnName="id", nullable=false)
     */
    private $bord;

    /**
     * @ORM\ManyToOne(targetEntity=Contribute::class, inversedBy="messages",cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="contribute_id", referencedColumnName="id", nullable=false)
     */
    private $contribute;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $delete_flg;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getToUser(): ?User
    {
        return $this->to_user;
    }

    public function setToUser(?User $to_user): self
    {
        $this->to_user = $to_user;

        return $this;
    }

    public function getFromUser(): ?User
    {
        return $this->from_user;
    }

    public function setFromUser(?User $from_user): self
    {
        $this->from_user = $from_user;

        return $this;
    }

    public function getBord(): ?Bord
    {
        return $this->bord;
    }

    public function setBord(?Bord $bord): self
    {
        $this->bord = $bord;

        return $this;
    }

    public function getContribute(): ?Contribute
    {
        return $this->contribute;
    }

    public function setContribute(?Contribute $contribute): self
    {
        $this->contribute = $contribute;

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

    public function setDeleteFlg(bool $delete_flg): self
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
}
