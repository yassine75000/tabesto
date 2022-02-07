<?php

namespace App\Entity;

use App\Repository\AdventureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdventureRepository::class)
 */
class Adventure
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
    private $score;

    /**
     * @ORM\OneToOne(targetEntity=Character::class, mappedBy="adenture", cascade={"persist", "remove"})
     */
    private $personnage;

    /**
     * @ORM\OneToMany(targetEntity=Tile::class, mappedBy="adventure")
     */
    private $tiles;

    public function __construct()
    {
        $this->tiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getPersonnage(): ?Character
    {
        return $this->personnage;
    }

    public function setPersonnage(?Character $personnage): self
    {
        // unset the owning side of the relation if necessary
        if ($personnage === null && $this->personnage !== null) {
            $this->personnage->setAdenture(null);
        }

        // set the owning side of the relation if necessary
        if ($personnage !== null && $personnage->getAdenture() !== $this) {
            $personnage->setAdenture($this);
        }

        $this->personnage = $personnage;

        return $this;
    }

    /**
     * @return Collection|Tile[]
     */
    public function getTiles(): Collection
    {
        return $this->tiles;
    }

    public function addTile(Tile $tile): self
    {
        if (!$this->tiles->contains($tile)) {
            $this->tiles[] = $tile;
            $tile->setAdventure($this);
        }

        return $this;
    }

    public function removeTile(Tile $tile): self
    {
        if ($this->tiles->removeElement($tile)) {
            // set the owning side to null (unless already changed)
            if ($tile->getAdventure() === $this) {
                $tile->setAdventure(null);
            }
        }

        return $this;
    }
}
