<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartRepository")
 */
class ShoppingCart
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
    private $IdShopping_cart;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Item")
     */
    private $fk_Item;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="User_shoppingCart", cascade={"persist", "remove"})
     */
    private $fk_User;

    public function __construct()
    {
        $this->fk_Item = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdShoppingCart(): ?int
    {
        return $this->IdShopping_cart;
    }

    public function setIdShoppingCart(int $IdShopping_cart): self
    {
        $this->IdShopping_cart = $IdShopping_cart;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getFkItem(): Collection
    {
        return $this->fk_Item;
    }

    public function addFkItem(Item $fkItem): self
    {
        if (!$this->fk_Item->contains($fkItem)) {
            $this->fk_Item[] = $fkItem;
        }

        return $this;
    }

    public function removeFkItem(Item $fkItem): self
    {
        if ($this->fk_Item->contains($fkItem)) {
            $this->fk_Item->removeElement($fkItem);
        }

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
