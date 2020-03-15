<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 * @Vich\Uploadable
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->fk_Store = new ArrayCollection();
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;

        if ($image)
            $this->updatedAt = new \DateTime('now');
    }

    public function getImage()
    {
        return $this->image;
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

    public function getFkStore_one(): string
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
    public function __toString(): string
    {
        return $this->id;
    }
}
