<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransporterRepository")
 */
class Transporter
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
    private $IdTransporter;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enabled;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTransporter(): ?int
    {
        return $this->IdTransporter;
    }

    public function setIdTransporter(int $IdTransporter): self
    {
        $this->IdTransporter = $IdTransporter;

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
