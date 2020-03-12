<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
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
    private $IdItem;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Weight;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Store", inversedBy="items")
     */
    private $fk_Store;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enabled;

    public function __construct()
    {
        $this->fk_Store = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdItem(): ?int
    {
        return $this->IdItem;
    }

    public function setIdItem(int $IdItem): self
    {
        $this->IdItem = $IdItem;

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

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(?int $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->Weight;
    }

    public function setWeight(?int $Weight): self
    {
        $this->Weight = $Weight;

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
}
