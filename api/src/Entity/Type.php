<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proces", mappedBy="type", orphanRemoval=true)
     */
    private $processes;

    public function __construct()
    {
        $this->processes = new ArrayCollection();
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

    /**
     * @return Collection|Proces[]
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function addProcess(Proces $process): self
    {
        if (!$this->processes->contains($process)) {
            $this->processes[] = $process;
            $process->setType($this);
        }

        return $this;
    }

    public function removeProcess(Proces $process): self
    {
        if ($this->processes->contains($process)) {
            $this->processes->removeElement($process);
            // set the owning side to null (unless already changed)
            if ($process->getType() === $this) {
                $process->setType(null);
            }
        }

        return $this;
    }
}
