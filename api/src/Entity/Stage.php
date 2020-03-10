<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

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
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/stages/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/stages/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 * @Gedmo\Loggable(logEntryClass="App\Entity\ChangeLog")
 * 
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 */
class Stage
{
    /**
     * @var UuidInterface The UUID identifier of this object
     *
     * @example e2984465-190a-4562-829e-a8cca81aa35d
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
     * @Gedmo\Versioned
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
     * @Gedmo\Versioned
     * @Assert\Length(
     *      max = 2550
     * )
     * @Groups({"read"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string The icon of this property
     *
     * @example My Property
     *
     * @Gedmo\Versioned
     * @Assert\Length(min = 15, max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @var string The task type of the stage
     *
     * @example my-organisation
     *
     * @Gedmo\Versioned
     * @Assert\Choice({"service","send","receive","user","manual","business rule","script"})
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $type = 'user';

    /**
     * @var object The options or configuration for this stage
     *
     * @example my-organisation
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="json", nullable=true)
     */
    private $options = [];

    /**
     * @var object The validation rules that this stage adheres to
     *
     * @example my-organisation
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max=255
     * )
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
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", inversedBy="previous", cascade={"persist", "remove"})
     */
    private $next;

    /**
     * @param Stage $previous The previues stage from this one
     *
     * @MaxDepth(1)
     * @Groups({"read","write"})
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="App\Entity\Stage", mappedBy="next", cascade={"persist", "remove"})
     */
    private $previous;

    /**
     * @param string The request property that is used for this stage
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $property;
    
    /**
     * @var string The slug of this property
     *
     * @example my-slug
     *
     * @Gedmo\Versioned
     * @Assert\Length(min = 15, max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;
    
    /**
     * @var string Whether or not this proerty is the starting oint of a process
     *
     * @example true
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $start = false;
    
    /**
     * @var Datetime $dateCreated The moment this request was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;
    
    /**
     * @var Datetime $dateModified  The moment this request last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

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
    
    public function getIcon(): ?string
    {
    	return $this->icon;
    }
    
    public function setIcon(?string $icon): self
    {
    	$this->icon = $icon;
    	
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
    
    public function getSlug(): ?string
    {
    	return $this->slug;
    }
    
    public function setSlug(?string $slug): self
    {
    	$this->slug = $slug;
    	
    	return $this;
    }
    
    public function getStart(): ?bool
    {
    	return $this->start;
    }
    
    public function setStart(bool $start): self
    {
    	$this->start = $start;
    	
    	return $this;
    }
    
    public function getDateCreated(): ?\DateTimeInterface
    {
    	return $this->dateModified;
    }
    
    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
    	$this->dateCreated= $dateCreated;
    	
    	return $this;
    }
    
    public function getDateModified(): ?\DateTimeInterface
    {
    	return $this->dateModified;
    }
    
    public function setDateModified(\DateTimeInterface $dateModified): self
    {
    	$this->dateModified = $dateModified;
    	
    	return $this;
    }
}
