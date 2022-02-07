<?php

namespace App\Entity;

use App\Repository\TileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TileRepository::class)
 */
class Tile
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $special_effects;

    /**
     * @ORM\ManyToOne(targetEntity=Adventure::class, inversedBy="tiles")
     */
    private $adventure;

    /**
     * @ORM\OneToOne(targetEntity=Monster::class, inversedBy="tile", cascade={"persist", "remove"})
     */
    private $monster;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSpecialEffects(): ?string
    {
        return $this->special_effects;
    }

    public function setSpecialEffects(string $special_effects): self
    {
        $this->special_effects = $special_effects;

        return $this;
    }

    public function getAdventure(): ?Adventure
    {
        return $this->adventure;
    }

    public function setAdventure(?Adventure $adventure): self
    {
        $this->adventure = $adventure;

        return $this;
    }

    public function getMonster(): ?Monster
    {
        return $this->monster;
    }

    public function setMonster(?Monster $monster): self
    {
        $this->monster = $monster;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }
}
