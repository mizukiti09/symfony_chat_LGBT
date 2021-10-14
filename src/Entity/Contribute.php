<?php

namespace App\Entity;

use App\Repository\ContributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContributeRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Contribute
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
    private $textarea;

    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contributes", cascade={"persist", "remove" })
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
     * @ORM\OneToMany(targetEntity=Bord::class, mappedBy="contribute")
     */
    private $bords;

    public function __construct()
    {
        $this->bords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextarea(): ?string
    {
        return $this->textarea;
    }

    public function setTextarea(string $textarea): self
    {
        $this->textarea = $textarea;

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
            $bord->setContribute($this);
        }

        return $this;
    }

    public function removeBord(Bord $bord): self
    {
        if ($this->bords->removeElement($bord)) {
            // set the owning side to null (unless already changed)
            if ($bord->getContribute() === $this) {
                $bord->setContribute(null);
            }
        }

        return $this;
    }
}
