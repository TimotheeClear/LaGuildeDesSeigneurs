<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table (name="characters")
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
    * @Assert\NotBlank
    * @Assert\Length(
    *     min = 3,
    *     max = 16,
    * )
    * @ORM\Column(type="string")
    */
    private $name;


    /**
    * @Assert\NotBlank
    * @Assert\Length(
    *     min = 3,
    *     max = 64,
    * )
    * @ORM\Column(type="string")
    */
    private $surname;

    /**
    * @Assert\Length(
    *     min = 3,
    *     max = 16,
    * )
    */
    private $caste;

    /**
    * @Assert\Length(
    *     min = 3,
    *     max = 16,
    * )
    * @ORM\Column(type="string")
    */
    private $knowledge;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $life;

    /**
    * @Assert\Length(
    *     min = 5,
    *     max = 128,
    * )
    * @ORM\Column(type="string")
    */
    private $image;

    /**
     *  @Assert\NotBlank
     *  @Assert\Length(
     *      min = 3,
     *      max = 16,
     *  )
     * @ORM\Column(type="string")
     */
    private $kind;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $creation;

    /**
    * @Assert\Length(
    *     min = 40,
    *     max = 40,
    * )
    * @ORM\Column(type="string")
    */
    private $identifier;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modification;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="characters")
     */
    private $player;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCaste(): ?string
    {
        return $this->caste;
    }

    public function setCaste(?string $caste): self
    {
        $this->caste = $caste;

        return $this;
    }

    public function getKnowledge(): ?string
    {
        return $this->knowledge;
    }

    public function setKnowledge(?string $knowledge): self
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(?int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(?int $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function setKind(string $kind): self
    {
        $this->kind = $kind;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getModification(): ?\DateTimeInterface
    {
        return $this->modification;
    }

    public function setModification(?\DateTimeInterface $modification): self
    {
        $this->modification = $modification;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}
