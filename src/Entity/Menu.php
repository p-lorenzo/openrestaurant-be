<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=MenuSection::class, mappedBy="menu")
     */
    private $sections;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|MenuSection[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(MenuSection $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setMenu($this);
        }

        return $this;
    }

    public function removeSection(MenuSection $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getMenu() === $this) {
                $section->setMenu(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
