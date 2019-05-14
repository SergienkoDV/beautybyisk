<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="sections")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Worksheets", mappedBy="section")
     */
    private $worksheets;

    public function __construct()
    {
        $this->worksheets = new ArrayCollection();
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

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|Worksheets[]
     */
    public function getWorksheets(): Collection
    {
        return $this->worksheets;
    }

    public function addWorksheet(Worksheets $worksheet): self
    {
        if (!$this->worksheets->contains($worksheet)) {
            $this->worksheets[] = $worksheet;
            $worksheet->setSection($this);
        }

        return $this;
    }

    public function removeWorksheet(Worksheets $worksheet): self
    {
        if ($this->worksheets->contains($worksheet)) {
            $this->worksheets->removeElement($worksheet);
            // set the owning side to null (unless already changed)
            if ($worksheet->getSection() === $this) {
                $worksheet->setSection(null);
            }
        }

        return $this;
    }

}
