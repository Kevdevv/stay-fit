<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $sell_drink = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'structure')]
    private ?Franchise $franchise = null;

    #[ORM\Column]
    private ?bool $mailing = null;

    #[ORM\Column]
    private ?bool $promotion_salle = null;

    #[ORM\Column]
    private ?bool $team_planning = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column]
    private ?bool $active = null;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getFranchise(): ?Franchise
    {
        return $this->franchise;
    }

    public function setFranchise(?Franchise $franchise): self
    {
        $this->franchise = $franchise;

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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
