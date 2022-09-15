<?php

namespace App\Entity;

use App\Repository\FranchiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FranchiseRepository::class)]
class Franchise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $sell_drink = null;

    #[ORM\OneToMany(mappedBy: 'franchise', targetEntity: Structure::class)]
    private Collection $structure;

    #[ORM\Column]
    private ?bool $mailing = null;

    #[ORM\Column]
    private ?bool $promotion_salle = null;

    #[ORM\Column]
    private ?bool $team_planning = null;

    #[ORM\Column]
    private ?bool $active = null;

    public function __construct()
    {
        $this->structure = new ArrayCollection();
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

    public function isSellDrink(): ?bool
    {
        return $this->sell_drink;
    }

    public function setSellDrink(bool $sell_drink): self
    {
        $this->sell_drink = $sell_drink;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructure(): Collection
    {
        return $this->structure;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structure->contains($structure)) {
            $this->structure->add($structure);
            $structure->setFranchise($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structure->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getFranchise() === $this) {
                $structure->setFranchise(null);
            }
        }

        return $this;
    }

    public function isMailing(): ?bool
    {
        return $this->mailing;
    }

    public function setMailing(bool $mailing): self
    {
        $this->mailing = $mailing;

        return $this;
    }

    public function isPromotionSalle(): ?bool
    {
        return $this->promotion_salle;
    }

    public function setPromotionSalle(bool $promotion_salle): self
    {
        $this->promotion_salle = $promotion_salle;

        return $this;
    }

    public function isTeamPlanning(): ?bool
    {
        return $this->team_planning;
    }

    public function setTeamPlanning(bool $team_planning): self
    {
        $this->team_planning = $team_planning;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
