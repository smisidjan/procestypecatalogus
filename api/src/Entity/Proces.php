<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource( 
 *  collectionOperations={
 *  	"get",
 *  	"post"
 *  },
 * 	itemOperations={
 *     "get"={
 *  		"swagger_context" = {
 *                  "parameters" = {
 *                      {
 *                          "name" = "extend",
 *                          "in" = "query",
 *                          "description" = "Add the properties of the requestType that this proces extends, requires the request type to be publicly available",
 *                          "required" = "false",
 *                          "type" : "boolean"
 *                      }
 *                  }
 *          }        
 *  	},
 *     "put",
 *     "delete"
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProcesRepository")
 */
class Proces
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $icon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rsin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="procceses", orphanRemoval=true)
     */
    private $stages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $verzoek;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="processes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;


    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getIcon(): ?string
    {
    	return $this->icon;
    }
    
    public function setIcon(string $icon): self
    {
    	$this->icon = $icon;
    	
    	return $this;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $Description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getRsin(): ?string
    {
        return $this->rsin;
    }

    public function setRsin(string $rsin): self
    {
        $this->rsin = $rsin;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setProcceses($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getProcceses() === $this) {
                $stage->setProcceses(null);
            }
        }

        return $this;
    }

    public function getVerzoek(): ?string
    {
        return $this->verzoek;
    }

    public function setVerzoek(string $verzoek): self
    {
        $this->verzoek = $verzoek;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(string $request): self
    {
        $this->request = $request;

        return $this;
    }
}
