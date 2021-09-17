<?php

namespace App\Entity;

use App\Repository\MenuSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MenuSectionRepository::class)
 */
class MenuSection
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @Groups("public")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("public")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups("public")
     */
    private $sorting;

    /**
     * @ORM\OneToMany(targetEntity=MenuEntry::class, mappedBy="menuSection")
     * @Groups("public")
     */
    private $entries;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="sections")
     */
    private $menu;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?string
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
