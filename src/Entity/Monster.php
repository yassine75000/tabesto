<?php

namespace App\Entity;

use App\Repository\MonsterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonsterRepository::class)
 */
class Monster
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $life_point;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attack_value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $armor_value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=Tile::class, mappedBy="monster", cascade={"persist", "remove"})
     */
    private $tile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLifePoint(): ?int
    {
        return $this->life_point;
    }

    public function setLifePoint(int $life_point): self
    {
        $this->life_point = $life_point;

        return $this;
    }

    public function getAttackValue(): ?string
    {
        return $this->attack_value;
    }

    public function setAttackValue(string $attack_value): self
    {
        $this->attack_value = $attack_value;

        return $this;
    }

    public function getArmorValue(): ?string
    {
        return $this->armor_value;
    }

    public function setArmorValue(string $armor_value): self
    {
        $this->armor_value = $armor_value;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTile(): ?Tile
    {
        return $this->tile;
    }

    public function setTile(?Tile $tile): self
    {
        // unset the owning side of the relation if necessary
        if ($tile === null && $this->tile !== null) {
            $this->tile->setMonster(null);
        }

        // set the owning side of the relation if necessary
        if ($tile !== null && $tile->getMonster() !== $this) {
            $tile->setMonster($this);
        }

        $this->tile = $tile;

        return $this;
    }
}
