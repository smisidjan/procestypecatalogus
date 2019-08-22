<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $options = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $validation = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proces", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $procceses;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="previous", cascade={"persist", "remove"})
     */
    private $next;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", mappedBy="next", cascade={"persist", "remove"})
     */
    private $previous;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $parameter;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getProcceses(): ?Proces
    {
        return $this->procceses;
    }

    public function setProcceses(?Proces $procceses): self
    {
        $this->procceses = $procceses;

        return $this;
    }
    
    public function getNext(): ?self
    {
        return $this->next;
    }

    public function setNext(?self $next): self
    {
        $this->next = $next;

        return $this;
    }

    public function getPrevious(): ?self
    {
        return $this->previous;
    }

    public function setPrevious(?self $previous): self
    {
        $this->previous = $previous;

        // set (or unset) the owning side of the relation if necessary
        $newNext = $previous === null ? null : $this;
        if ($newNext !== $previous->getNext()) {
            $previous->setNext($newNext);
        }

        return $this;
    }

    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    public function setParameter(string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }
}
