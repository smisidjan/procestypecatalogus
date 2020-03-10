<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogoRepository")
 * @Gedmo\Loggable(logEntryClass="App\Entity\ChangeLog")
 *
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiFilter(DateFilter::class, strategy=DateFilter::EXCLUDE_NULL)
 * @ApiFilter(SearchFilter::class)
 */
class Logo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	private $id;

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

    public function getId(): ?int
    {
        return $this->id;
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
