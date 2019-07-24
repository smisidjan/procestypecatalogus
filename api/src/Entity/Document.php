<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $options = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $validation = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proces", inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proces;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getValidation(): ?array
    {
        return $this->validation;
    }

    public function setValidation(?array $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getProces(): ?Proces
    {
        return $this->proces;
    }

    public function setProces(?Proces $proces): self
    {
        $this->proces = $proces;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }
}
