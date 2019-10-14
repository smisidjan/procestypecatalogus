<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * A process
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
 *  normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *  denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
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
 *                          "description" = "Add the properties of the requestType that this process utilizes, requires the request type to be publicly available",
 *                          "required" = false,
 *                          "type" : "boolean"
 *                      }
 *                  }
 *          }
 *  	},
 *     "put",
 *     "delete"
 *  }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProcessTypeRepository")
 */
class ProcessType
{
	/**
     * @var \Ramsey\Uuid\UuidInterface $id The UUID identifier of this object
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
	 * @var string $name The name of this process
     * @example My process
	 *
	 * @ApiProperty(
     * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The name of this process",
	 *             "type"="string",
	 *             "format"="url",
	 *             "example"="https://imbag.github.io/praktijkhandleiding/assets/img/vng.svg",
	 *              "maxLength"=255
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
	 * @var string $subtitle The subtitle of this process
     * @example"An example process
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The subtitle of this process",
	 *             "type"="string",
	 *             "example"="My process",
	 *              "maxLength"=255
	 *         }
	 *     }
	 * )
	 *
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read", "write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $subtitle;
	
	/**
	 * @var string $description An short description of this process
     * @example This is the best process ever
	 *
	 * @ApiProperty(
     * 	   iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An short description of this process",
	 *             "type"="string",
	 *             "example"="An example process",
	 *              "maxLength"=255
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
	 * @var string $logo The logo for this process
	 * @example https://www.my-organisation.com/logo.png
	 *
	 * @ApiProperty(
	 * 	   iri="https://schema.org/logo",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The logo for this process",
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
	 * @var string $sourceOrganization The RSIN of the organization that owns this process
	 * @example 002851234
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The RSIN of the organization that owns this process",
	 *             "type"="string",
	 *             "example"="002851234",
	 *              "maxLength"="255"
	 *         }
	 *     }
	 * )
	 *
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 11
	 * )
	 * @Groups({"read", "write"})
	 * @ORM\Column(type="string", length=255)
	 * @ApiFilter(SearchFilter::class, strategy="exact")
	 */
	private $sourceOrganization;
	
	/**
	 * @var array $stages The stages of this process
	 *
     * @MaxDepth(1)
	 * @Groups({"read", "write"})
	 * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="process", orphanRemoval=true, fetch="EAGER", cascade={"persist"})
	 */
	private $stages;
	
	/**
	 * @var string $request The request that is used for this process
	 * @example http://rtc.zaakonline.nl/9bd169ef-bc8c-4422-86ce-a0e7679ab67a
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The request that is used for this process",
	 *             "type"="string",
	 *             "format"="uri",
	 *             "example"="http://requests.zaakonline.nl/properties/9bd169ef-bc8c-4422-86ce-a0e7679ab67a",
	 *              "maxLength"=255
	 *         }
	 *     }
	 * )
	 *
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
	 * @Groups({"read", "write"})
	 * @ORM\Column(type="string", length=255)
	 */
	private $request;
	
	/**
	 * @var object $extends The process that this process extends
	 *
     * @MaxDepth(1)
	 * @Groups({"write"})
	 * @ORM\ManyToOne(targetEntity="App\Entity\ProcessType", inversedBy="extendedBy", fetch="EAGER")
	 */
	private $extends;
	
	/**
	 * @var object $extendedBy The processs that extend this process
	 * 
     * @MaxDepth(1)
	 * @ORM\OneToMany(targetEntity="App\Entity\ProcessType", mappedBy="extends")
	 */
	private $extendedBy;
	
	/**
	 * @param array The properties property is used internally for validation and extending and serves as an array of property UUID's against which can be checked for double properties
	 */
	private $properties;
	
	
	public function __construct()
	{
		$this->stages = new ArrayCollection();
		$this->extendedBy = new ArrayCollection();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId(string $id): self
	{
		$this->id = $id;
		
		return $this;
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
	
	public function getSubtitle(): ?string
	{
		return $this->subtitle;
	}
	
	public function setSubtitle(string $subtitle): self
	{
		$this->subtitle = $subtitle;
		
		return $this;
	}
	
	public function getSourceOrganization(): ?string
	{
		return $this->sourceOrganization;
	}
	
	public function setSourceOrganization(string $sourceOrganization): self
	{
		$this->sourceOrganization = $sourceOrganization;
		
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
	
	public function getRequest(): ?string
	{
		return $this->request;
	}
	
	public function setRequest(string $request): self
	{
		$this->request = $request;
		
		return $this;
	}
	
	public function getExtends(): ?self
	{
		return $this->extends;
	}
	
	public function setExtends(?self $extends): self
	{
		$this->extends = $extends;
		
		return $this;
	}
	
	/**
	 * @return Collection|self[]
	 */
	public function getExtendedBy(): Collection
	{
		return $this->extendedBy;
	}
	
	public function addExtendedBy(self $extendedBy): self
	{
		if (!$this->extendedBy->contains($extendedBy)) {
			$this->extendedBy[] = $extendedBy;
			$extendedBy->setExtends($this);
		}
		
		return $this;
	}
	
	public function removeExtendedBy(self $extendedBy): self
	{
		if ($this->extendedBy->contains($extendedBy)) {
			$this->extendedBy->removeElement($extendedBy);
			// set the owning side to null (unless already changed)
			if ($extendedBy->getExtends() === $this) {
				$extendedBy->setExtends(null);
			}
		}
		
		return $this;
	}
	
	public function getProperties()
	{
		return $this->properties;
	}
	
	public function addProperty(string $property): self
	{
		if (!in_array($property, $this->properties)) {
			$this->properties[] = $property;
		}
		
		return $this;
	}
	
	public function removeProperty(string $property): self
	{
		if (in_array($property, $this->properties)) {
			unset($this->properties[$property]);
		}
		
		return $this;
	}
}

