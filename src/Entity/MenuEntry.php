<?php

namespace App\Entity;

use App\Repository\MenuEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MenuEntryRepository::class)
 */
class MenuEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("public")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("public")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups("public")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("public")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=MenuSection::class, inversedBy="MenuEntry")
     */
    private $menuSection;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMenuSection(): ?MenuSection
    {
        return $this->menuSection;
    }

    public function setMenuSection(?MenuSection $menuSection): self
    {
        $this->menuSection = $menuSection;

        return $this;
    }

    public static function withData(string $name, float $price, int $quantity, string $description = null): MenuEntry
    {
        $menuEntry = new self();
        $menuEntry->setName($name);
        $menuEntry->setDescription($description);
        $menuEntry->setPrice($price);
        $menuEntry->setQuantity($quantity);
        return $menuEntry;
    }
}
