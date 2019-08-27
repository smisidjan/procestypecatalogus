<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A single stage within a process
 *
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 *
 * @version    	1.0
 *
 * @link   		http//:www.conduction.nl
 * @package		Common Ground Component
 * @subpackage  Processes
 * 
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *	 
     * @ApiProperty(
     * 	   identifier=true,
     *     attributes={
     *         "swagger_context"={
	 *         	   "description" = "The UUID identifier of this object",
     *             "type"="string",
     *             "format"="uuid",
     *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
     *         }
     *     }
     * )
     *
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @param string The name of this stage
     *     
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
 	 *         	   "description" = "The name of this stage",
     *             "type"="string",
     *             "example"="The first stage",
 	*              "maxLength"="255"
     *         }
     *     }
     * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @param string The description of this stage
     *
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The description of this stage",
     *             "type"="string",
     *             "example"="In this stage we ask the user for an email address"
     *         }
     *     }
     * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    /**
     * @param string The task type of the stage
     *     
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
 	 *         	   "description" = "The task type of the stage",
     *             "type"="string",
     *             "enum"={"service", "send", "receive","user","manual","business rule","script"},
     *             "example"="user",
     *             "default"="user"
     *         }
     *     }
     * )      
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $type = "user";

    /**
     * @param object The options or configuration for this stage
     * 
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
 	 *         	   "description" = "The options or configuration for this stage",
     *             "type"="object",
     *             "example"={
     *             }
     *         }
     *     }
     * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="json", nullable=true)
     */
    private $options = [];

    /**
     * @param object The validation rules that this stage adheres to
     * 
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
 	 *         	   "description" = "The validation rules that this stage adhers to",
     *             "type"="object",
     *             "example"={
     *             		"title":"user_email",
     *             		"type":"string",
     *             		"format":"email",
     *             		"maxLength":255,
     *             		"required":true
     *             }
     *         }
     *     }
     * )
     * 
     * @Groups({"read"})
     * @ORM\Column(type="json", nullable=true)
     */
    private $validation = [];

    /**
     * @param object The process that this stage belongs to
     * 
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="App\Entity\Process", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $process;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="previous", cascade={"persist", "remove"})
     */
    private $next;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", mappedBy="next", cascade={"persist", "remove"})
     */
    private $previous;

    /**
     * @param string The property that is used for this stage
     * 
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
 	 *         	   "description" = "The property that is used for this stage",
     *             "type"="string",
     *             "format"="uri",
     *             "example"="http://requests.zaakonline.nl/properties/9bd169ef-bc8c-4422-86ce-a0e7679ab67a",
 	*              "maxLength"="255"
     *         }
     *     }
     * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $property;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId()
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

    public function getProcess(): ?Process
    {
        return $this->process;
    }

    public function setProcess(?Process $process): self
    {
        $this->process = $process;

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

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function setProperty(string $property): self
    {
    	$this->property = $property;

        return $this;
    }
}
