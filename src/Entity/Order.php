<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $IdOrder;

    /**
     * @ORM\Column(type="integer")
     */
    private $Price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Store", inversedBy="Store_orders")
     */
    private $fk_Store;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enabled;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="User_orders")
     */
    private $fk_User;

    public function __construct()
    {
        $this->fk_Store = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrder(): ?int
    {
        return $this->IdOrder;
    }

    public function setIdOrder(int $IdOrder): self
    {
        $this->IdOrder = $IdOrder;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getFkStore(): Collection
    {
        return $this->fk_Store;
    }

    public function addFkStore(Store $fkStore): self
    {
        if (!$this->fk_Store->contains($fkStore)) {
            $this->fk_Store[] = $fkStore;
        }

        return $this;
    }

    public function removeFkStore(Store $fkStore): self
    {
        if ($this->fk_Store->contains($fkStore)) {
            $this->fk_Store->removeElement($fkStore);
        }

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->Enabled;
    }

    public function setEnabled(bool $Enabled): self
    {
        $this->Enabled = $Enabled;

        return $this;
    }

    public function getFkUser(): ?User
    {
        return $this->fk_User;
    }

    public function setFkUser(?User $fk_User): self
    {
        $this->fk_User = $fk_User;

        return $this;
    }
}
