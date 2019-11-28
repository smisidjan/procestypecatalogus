<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A single stage within a process.
 *
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 *
 *
 * @version    	1.0
 *
 * @link   		http://www.conduction.nl
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @var UuidInterface The UUID identifier of this object
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
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
     * @Assert\Uuid
     * @Groups({"read"})
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var string The name of this stage
     *
     * @example Stage 1
     *
     * @ApiProperty(
     * 	   iri="https://schema.org/name",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The name of this stage",
     *             "type"="string",
     *             "example"="Stage 1",
     *             "maxLength"="255",
     *             "required" = true
     *         }
     *     }
     * )
     *
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string An short description of this stage
     *
     * @example Please enter your email adres
     *
     * @ApiProperty(
     * 	   iri="https://schema.org/description",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "An short description of this stage",
     *             "type"="string",
     *             "example"="Please enter your email adres",
     *             "maxLength"=2550
     *         }
     *     }
     * )
     *
     * @Assert\Length(
     *      max = 2550
     * )
     * @Groups({"read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string The logo for this stage
     *
     * @example https://www.my-organisation.com/logo.png
     *
     * @ApiProperty(
     * 	   iri="https://schema.org/logo",
     *     attributes={
     *         "swagger_context"={
     *         	   "description" = "The logo for this stage",
     *             "type"="string",
     *             "format"="url",
     *             "example"="https://www.my-organisation.com/logo.png",
     *             "maxLength"="255"
     *         }
     *     }
     * )
     *
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var string The task type of the stage
     *
     * @example my-organisation
     * @Assert\Choice({"service","send","receive","user","manual","business rule","script"})
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
    private $type = 'user';

    /**
     * @var object The options or configuration for this stage
     *
     * @example my-organisation
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
     * @var object The validation rules that this stage adheres to
     *
     * @example my-organisation
     * @Assert\Length(
     *     max=255
     * )
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
     * @var object ProcessType The process that this stage belongs to
     *
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessType", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $process;

    /**
     * @param Stage $next The next stage from this one
     *
     * @MaxDepth(1)
     * @Groups({"read","write"})
     * @Asert\Valid
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="previous", cascade={"persist", "remove"})
     */
    private $next;

    /**
     * @param Stage $previous The previues stage from this one
     *
     * @MaxDepth(1)
     * @Groups({"read","write"})
     * @Asert\Valid
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", mappedBy="next", cascade={"persist", "remove"})
     */
    private $previous;

    /**
     * @param string The request property that is used for this stage
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
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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

    public function getProcess(): ?ProcessType
    {
        return $this->process;
    }

    public function setProcess(?ProcessType $process): self
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
