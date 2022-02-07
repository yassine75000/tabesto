<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character
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
     * @ORM\Column(type="integer")
     */
    private $armor_value;

    /**
     * @ORM\OneToOne(targetEntity=Adventure::class, inversedBy="personnage", cascade={"persist", "remove"})
     */
    private $adenture;

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

    public function getArmorValue(): ?int
    {
        return $this->armor_value;
    }

    public function setArmorValue(int $armor_value): self
    {
        $this->armor_value = $armor_value;

        return $this;
    }

    public function getAdenture(): ?Adventure
    {
        return $this->adenture;
    }

    public function setAdenture(?Adventure $adenture): self
    {
        $this->adenture = $adenture;

        return $this;
    }
}
