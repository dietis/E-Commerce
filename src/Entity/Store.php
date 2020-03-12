<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
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
    private $IdStore;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enabled;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item", mappedBy="fk_Store")
     */
    private $items;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", mappedBy="fk_Store")
     */
    private $Store_orders;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->Store_orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStore(): ?int
    {
        return $this->IdStore;
    }

    public function setIdStore(int $IdStore): self
    {
        $this->IdStore = $IdStore;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

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

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->addFkStore($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            $item->removeFkStore($this);
        }

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getStoreOrders(): Collection
    {
        return $this->Store_orders;
    }

    public function addStoreOrder(Order $storeOrder): self
    {
        if (!$this->Store_orders->contains($storeOrder)) {
            $this->Store_orders[] = $storeOrder;
            $storeOrder->addFkStore($this);
        }

        return $this;
    }

    public function removeStoreOrder(Order $storeOrder): self
    {
        if ($this->Store_orders->contains($storeOrder)) {
            $this->Store_orders->removeElement($storeOrder);
            $storeOrder->removeFkStore($this);
        }

        return $this;
    }
}
