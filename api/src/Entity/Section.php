<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true},
 *     itemOperations={
 *          "get",
 *          "put",
 *          "delete",
 *          "get_change_logs"={
 *              "path"="/sections/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/sections/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 * )
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
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
     * @var string the name of this Section
     *
     * @example Section 1
     * @Groups({"read","write"})
     * @Gedmo\Versioned
     * @Assert\Length(
     *     max=255
     * )
     * @Assert\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string the description for this section
     *
     * @example this section is for the personal data of the client
     *
     * @Groups({"read","write"})
     * @Gedmo\Versioned
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var array The properties that are treated in this section, as references to the VTC component
     *
     * @example https://vtc.processen.zaakonline.nl/properties/1
     * @Groups({"read","write"})
     * @Gedmo\Versioned
     *
     * @ORM\Column(type="array", nullable=true)
     */
    private $properties = [];
    /**
     * @var Stage the stage this section belongs to
     *
     * @MaxDepth(1)
     * @Groups({"read","write"}))
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    /**
     * @var DateTime The moment this request was created
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @var DateTime The moment this request last Modified
     *
     * @Groups({"read"})
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    /**
     * @var bool Denotes if this section is the first section of the stage
     *
     * @example true
     *
     * @Groups({"read"})
     */
    private $start = false;

    /**
     * @var bool Denotes if this section is the last section of the stage
     *
     * @example true
     *
     * @Groups({"read"})
     */
    private $end = false;

    /**
     * @var Section the next Section in the stage
     *
     * @MaxDepth(1)
     * @Groups({"write"}))
     */
    private $next;

    /**
     * @var Section the previous Section in the stage
     *
     * @MaxDepth(1)
     * @Groups({"write"}))
     */
    private $previous;

    /**
     * @var int The place in the order where the section should be rendered
     *
     * @Assert\NotNull
     * @Groups({"read","write"})
     * @ORM\Column(type="integer")
     */
    private $orderNumber = 0;

    public function getId(): ?Uuid
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

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function setProperties(?array $properties): self
    {
        $this->properties = $properties;

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

    public function getStart(): ?bool
    {
        if($this->getStage()->getFirstSection() == $this){
            return true;
        }

        return false;
    }

    public function getEnd(): ?bool
    {
        if($this->getStage()->getLastSection() == $this){
            return true;
        }

        return false;
    }


    public function getPrevious()
    {
        return $this->getProessType()->getPreviousSection($this);
    }

    public function getNext()
    {
        return $this->getProessType()->getPreviousSection($this);
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
        if(!$this->orderNumber || $this->orderNumber <= 0){
            $this->orderNumber = $this->getStage()->getSections()->indexOf($this) + 1;
        }
    }
}
