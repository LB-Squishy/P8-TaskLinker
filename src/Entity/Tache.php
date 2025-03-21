<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Employe $employe = null;

    /**
     * @var Collection<int, Creneau>
     */
    #[ORM\OneToMany(targetEntity: Creneau::class, mappedBy: 'tache', orphanRemoval: true)]
    private Collection $creneaus;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'tache')]
    private Collection $tags;

    public function __construct()
    {
        $this->creneaus = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): static
    {
        $this->employe = $employe;

        return $this;
    }

    /**
     * @return Collection<int, Creneau>
     */
    public function getCreneaus(): Collection
    {
        return $this->creneaus;
    }

    public function addCreneau(Creneau $creneau): static
    {
        if (!$this->creneaus->contains($creneau)) {
            $this->creneaus->add($creneau);
            $creneau->setTache($this);
        }

        return $this;
    }

    public function removeCreneau(Creneau $creneau): static
    {
        if ($this->creneaus->removeElement($creneau)) {
            // set the owning side to null (unless already changed)
            if ($creneau->getTache() === $this) {
                $creneau->setTache(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addTache($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeTache($this);
        }

        return $this;
    }
}
