<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorksheetsRepository")
 */
class Worksheets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profile", inversedBy="worksheets")
     */
    private $master;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="worksheets")
     */
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaster(): ?Profile
    {
        return $this->master;
    }

    public function setMaster(?Profile $master): self
    {
        $this->master = $master;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }
}
