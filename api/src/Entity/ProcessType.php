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
 * A process.
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
 *              "path"="/process_types/{id}/change_log",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Changelogs",
 *                  "description"="Gets al the change logs for this resource"
 *              }
 *          },
 *          "get_audit_trail"={
 *              "path"="/process_types/{id}/audit_trail",
 *              "method"="get",
 *              "swagger_context" = {
 *                  "summary"="Audittrail",
 *                  "description"="Gets the audit trail for this resource"
 *              }
 *          }
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ProcessTypeRepository")
 * @Gedmo\Loggable(logEntryClass="Conduction\CommonGroundBundle\Entity\ChangeLog")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 */
class ProcessType
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
     * @var string The name of this process
     *
     * @example My process
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
     * @var string The subtitle of this process
     * @example"An example process
     *
     * @Gedmo\Versioned
     * @Assert\NotNull
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $subtitle;

    /**
     * @var string An short description of this process
     *
     * @example This is the best process ever
     *
     * @Gedmo\Versioned
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read", "write"})
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

    /**
     * @var string A specific commonground organisation that is being reviewd, e.g a single product
     *
     * @example https://wrc.zaakonline.nl/organisations/16353702-4614-42ff-92af-7dd11c8eef9f
     *
     * @Gedmo\Versioned
     * @Assert\NotNull
     * @Assert\Url
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $sourceOrganization;

    /**
     * @var array The stages of this process
     *
     * @MaxDepth(1)
     * @Groups({"read", "write"})
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="process", orphanRemoval=true, fetch="EAGER", cascade={"persist"})
     * @ORM\OrderBy({"orderNumber" = "ASC"})
     */
    private $stages;

    /**
     * @var string The request that is used for this process
     *
     * @example http://rtc.zaakonline.nl/9bd169ef-bc8c-4422-86ce-a0e7679ab67a
     *
     * @Gedmo\Versioned
     * @Assert\Url
     * @Assert\Length(
     *      max = 255
     * )
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $requestType;

    /**
     * @var object The process that this process extends
     *
     * @MaxDepth(1)
     * @Groups({"write"})
     * @ORM\ManyToOne(targetEntity="App\Entity\ProcessType", inversedBy="extendedBy", fetch="EAGER")
     */
    private $extends;

    /**
     * @var object The processs that extend this process
     *
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\ProcessType", mappedBy="extends")
     */
    private $extendedBy;

    /**
     * @var string Whether or not to require a login. *none* means never require a user to login, user wil not be presented with the option to login, *optional* means the request presented with the option to login but not requered to do so, *onSubmit* means the user can not post the procces to the vrc without loggin in, *always* means that the user can not start the procces without loging in.
     *
     * @example optional
     *
     * @Gedmo\Versioned
     * @Assert\Choice({"none","optional","always","onSubmit"})
     * @Assert\Length(
     *      max = 10
     * )
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="string", length=10, options={"default" : "optional"})
     */
    private $login = 'optional';

    /**
     * @var string The audience this processType is intended for
     *
     * @Groups({"read","write"})
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $audience;

    /**
     * @var string The deposit requered for this process
     *
     * @example 50.00
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $deposit;

    /**
     * @var string The currency of the deposit price in an [ISO 4217](https://en.wikipedia.org/wiki/ISO_4217) format
     *
     * @example EUR
     *
     * @Gedmo\Versioned
     * @Assert\Currency
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     */
    private $depositCurrency;

    /**
     * @var int The deposit percentage requered for this proces
     *
     * @example 25
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $depositPercentage;

    /**
     * @var string The text displayed at the instruction stage.
     *
     * @example Dit proces is bedoelt om X te doen. Hier kun je meer vinden over X. etc.
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $instructionText;

    /**
     * @var bool wheter or not to dispay the instruction stage of a procces
     *
     * @example false
     *
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showInstructionStage = true;

    /**
     * @var string The text displayed at the submit stage.
     *
     * @example Na het indienen van dit verzoek zal uw verzoek binnen een week afgehandeld worden.
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $submitText;

    /**
     * @var bool wheter or not to dispay the submit stage of a procces
     *
     * @example false
     *
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showSubmitStage = true;

    /**
     * @var string The text displayed at the submitted stage.
     *
     * @example Uw verzoek zal binnen een week afgehandeld worden.
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $submittedText;

    /**
     * @var bool wheter or not to dispay the submitted stage of a procces
     *
     * @example false
     *
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showSubmittedStage = true;

    /**
     * @var bool wheter or not to display the back button to processes
     *
     * @example false
     *
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showBackButton = true;

    /**
     * @var bool whether or not to requests from this process are retractable
     *
     * @example false
     *
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $retractable = true;

    /**
     * @param array|string[] The request properties that are used for this process
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="array", length=255, nullable=true)
     */
    private $properties = [];

    /**
     * @param array|string[] The documents that are required for this proces
     *
     * @Gedmo\Versioned
     * @Groups({"read", "write"})
     * @ORM\Column(type="array", length=255, nullable=true)
     */
    private $documents = [];

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getAudience()
    {
        return $this->audience;
    }

    public function setAudience($audience): self
    {
        $this->audience = $audience;

        return $this;
    }

    public function getDeposit()
    {
        return $this->deposit;
    }

    public function setDeposit($deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getDepositCurrency(): ?string
    {
        return $this->depositCurrency;
    }

    public function setDepositCurrency(string $depositCurrency): self
    {
        $this->depositCurrency = $depositCurrency;

        return $this;
    }

    public function getDepositPercentage()
    {
        return $this->depositPercentage;
    }

    public function setDepositPercentage($depositPercentage): self
    {
        $this->depositPercentage = $depositPercentage;

        return $this;
    }

    public function getInstructionText(): ?string
    {
        return $this->instructionText;
    }

    public function setInstructionText(string $instructionText): self
    {
        $this->instructionText = $instructionText;

        return $this;
    }

    public function getShowInstructionStage(): ?bool
    {
        return $this->showInstructionStage;
    }

    public function setShowInstructionStage(?bool $showInstructionStage): self
    {
        $this->showInstructionStage = $showInstructionStage;

        return $this;
    }

    public function getShowBackButton(): ?bool
    {
        return $this->showBackButton;
    }

    public function setShowBackButton(?bool $showBackButton): self
    {
        $this->showBackButton = $showBackButton;

        return $this;
    }

    public function getRetractable(): ?bool
    {
        return $this->retractable;
    }

    public function setRetractable(?bool $retractable): self
    {
        $this->retractable = $retractable;

        return $this;
    }

    public function getSubmitText(): ?string
    {
        return $this->submitText;
    }

    public function setSubmitText(string $SubmitText): self
    {
        $this->submitText = $SubmitText;

        return $this;
    }

    public function getShowSubmitStage(): ?bool
    {
        return $this->showSubmitStage;
    }

    public function setShowSubmitStage(?bool $showSubmitStage): self
    {
        $this->showSubmitStage = $showSubmitStage;

        return $this;
    }

    public function getSubmittedText(): ?string
    {
        return $this->submittedText;
    }

    public function setSubmittedText(string $SubmittedText): self
    {
        $this->submittedText = $SubmittedText;

        return $this;
    }

    public function getShowSubmittedStage(): ?bool
    {
        return $this->showSubmittedStage;
    }

    public function setShowSubmittedStage(?bool $showSubmittedStage): self
    {
        $this->showSubmittedStage = $showSubmittedStage;

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
            $stage->setProcess($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getProcess() === $this) {
                $stage->setProcess(null);
            }
        }

        return $this;
    }

    // Stages logic

    public function getFirstStage()
    {
        return $this->getStages()->first();
    }

    public function getLastStage()
    {
        return $this->getStages()->last();
    }

    public function getPreviousStage($stage)
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->lt('orderNumber', $stage->getOrderNumber()));

        return $this->getStages()->matching($criteria)->last();
    }

    public function getNextStage($stage)
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->gt('orderNumber', $stage->getOrderNumber()));

        return $this->getStages()->matching($criteria)->first();
    }

    public function getMaxStage()
    {
        if ($this->getLastStage() && $this->getLastStage()->getOrderNumber()) {
            return $this->getLastStage()->getOrderNumber();
        }

        return 0;
    }

    public function getRequestType(): ?string
    {
        return $this->requestType;
    }

    public function setRequestType(string $requestType): self
    {
        $this->requestType = $requestType;

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

    public function getDocuments()
    {
        return $this->documents;
    }

    public function addDocument(string $documents): self
    {
        if (!in_array($documents, $this->documents)) {
            $this->documents[] = $documents;
        }

        return $this;
    }

    public function removeDocument(string $documents): self
    {
        if (in_array($documents, $this->documents)) {
            unset($this->documents[$documents]);
        }

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
}
