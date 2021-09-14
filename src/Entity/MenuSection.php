<?php

namespace App\Entity;

use App\Repository\MenuSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuSectionRepository::class)
 */
class MenuSection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $sorting;

    /**
     * @ORM\OneToMany(targetEntity=MenuEntry::class, mappedBy="menuSection")
     */
    private $entries;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="sections")
     */
    private $menu;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSorting(): ?int
    {
        return $this->sorting;
    }

    public function setSorting(int $sorting): self
    {
        $this->sorting = $sorting;

        return $this;
    }

    /**
     * @return Collection|MenuEntry[]
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(MenuEntry $entrie): self
    {
        if (!$this->entries->contains($entrie)) {
            $this->entries[] = $entrie;
            $entrie->setMenuSection($this);
        }

        return $this;
    }

    public function removeEntry(MenuEntry $entry): self
    {
        if ($this->entries->removeElement($entry)) {
            if ($entry->getMenuSection() === $this) {
                $entry->setMenuSection(null);
            }
        }

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public static function newMenuSection(string $title, int $sorting): MenuSection
    {
        $section = new self();
        $section->setTitle($title);
        $section->setSorting($sorting);
        return $section;
    }
}