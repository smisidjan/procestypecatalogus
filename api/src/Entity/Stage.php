<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
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
     * @Groups({"read", "write"})
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
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

//    /**
//     * @var string The task type of the stage
//     *
//     * @example my-organisation
//     *
//     * @Gedmo\Versioned
//     * @Assert\Choice({"service","send","receive","user","manual","business rule","script"})
//     * @Groups({"read", "write"})
//     * @ORM\Column(type="string", length=255)
//     */
//    private $type = 'user';

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
    private $validation;

    /**
     * @var ProcessType ProcessType The process that this stage belongs to
     *
     * @MaxDepth(1)
     * @Groups({"read","write"})
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessType", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $process;

    /**
     * @param Stage $next The next stage from this one
     *
     * @MaxDepth(1)
     * @Groups({"read"})
     */
    private $next;

    /**
     * @param Stage $previous The previues stage from this one
     *
     * @MaxDepth(1)
     * @Groups({"read"})
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
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string Whether or not this proerty is the starting point of a process
     *
     * @example true
     *
     * @Groups({"read"})
     */
    private $start = false;

    /**
     * @var string Whether or not this proerty is the last point of a process
     *
     * @example true
     *
     * @Groups({"read"})
     */
    private $end = false;

    /**
     * @var Datetime The moment this request was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var Datetime The moment this request last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    /**
     * @var ArrayCollection the sections of this stage
     *
     * @Groups({"read","write"})
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="stage", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"orderNumber" = "ASC"})
     */
    private $sections;

    /**
     * @var int The place in the order where the stage should be rendered
     *
     * @Assert\NotNull
     * @Groups({"read","write"})
     * @ORM\Column(type="integer")
     */
    private $orderNumber = 0;

    /**
     * @var ArrayCollection|Condition[] The conditions that have to be met for showing this section
     *
     * @Groups({"read","write"})
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity=Condition::class, mappedBy="stage", cascade={"persist","remove"})
     */
    private $conditions;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->conditions = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

//    public function getType(): ?string
//    {
//        return $this->type;
//    }
//
//    public function setType(string $type): self
//    {
//        $this->type = $type;
//
//        return $this;
//    }

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

    public function getPrevious()
    {
        return $this->getProcess()->getPreviousStage($this);
    }

    public function getNext()
    {
        return $this->getProcess()->getNextStage($this);
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
        if ($this->getProcess()->getFirstStage() == $this) {
            return true;
        }

        return false;
    }

    public function getEnd(): ?bool
    {
        if ($this->getProcess()->getLastStage() == $this) {
            return true;
        }

        return false;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

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

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setStage($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
            // set the owning side to null (unless already changed)
            if ($section->getStage() === $this) {
                $section->setStage(null);
            }
        }

        return $this;
    }

    // Section logic

    public function getFirstSection()
    {
        return $this->getSections()->first();
    }

    public function getLastSection()
    {
        return $this->getSections()->last();
    }

    public function getPreviouSection($section)
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->lt('orderNumber', $section->getOrderNumber()));

        return $this->getSections()->matching($criteria)->last();
    }

    public function getNextSection($stage)
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->gt('orderNumber', $section->getOrderNumber()));

        return $this->getSections()->matching($criteria)->first;
    }

    public function getMaxSection()
    {
        if ($this->getLastSection() && $this->getLastSection()->getOrderNumber()) {
            return $this->getLastSection()->getOrderNumber();
        }

        return 0;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function preFillOrderNumber()
    {
        if (!$this->orderNumber || $this->orderNumber <= 0) {
            $this->orderNumber = $this->getProcess()->getStages()->indexOf($this) + 1;
        }
    }

    /**
     * @return Collection|Condition[]
     */
    public function getConditions(): Collection
    {
        return $this->conditions;
    }

    public function addCondition(Condition $condition): self
    {
        if (!$this->conditions->contains($condition)) {
            $this->conditions[] = $condition;
            $condition->setStage($this);
        }

        return $this;
    }

    public function removeCondition(Condition $condition): self
    {
        if ($this->conditions->contains($condition)) {
            $this->conditions->removeElement($condition);
            // set the owning side to null (unless already changed)
            if ($condition->getStage() === $this) {
                $condition->setStage(null);
            }
        }

        return $this;
    }
}
