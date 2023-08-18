<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
#[ORM\Table(name: 'personas')]
class Persona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $primer_apellido = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $segundo_apellido = null;

    #[ORM\ManyToOne(inversedBy: 'personas')]
    #[ORM\JoinColumn(name:"direccion",nullable: false)]
    private ?Direccion $direccion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_nacimiento = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_fallecimiento = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $nif = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'madre')]
    #[ORM\JoinColumn(name:"madre")]
    private ?self $madre = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'padre')]
    #[ORM\JoinColumn(name:"padre")]
    private ?self $padre = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'tutor1')]
    #[ORM\JoinColumn(name:"tutor1")]
    private ?self $tutor1 = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'tutor2')]
    #[ORM\JoinColumn(name:"tutor2")]
    private ?self $tutor2 = null;

    public function __construct()
    {
        $this->madre = new ArrayCollection();
        $this->padre = new ArrayCollection();
        $this->tutor2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primer_apellido;
    }

    public function setPrimerApellido(string $primer_apellido): static
    {
        $this->primer_apellido = $primer_apellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundo_apellido;
    }

    public function setSegundoApellido(?string $segundo_apellido): static
    {
        $this->segundo_apellido = $segundo_apellido;

        return $this;
    }

    public function getDireccion(): ?Direccion
    {
        return $this->direccion;
    }

    public function setDireccion(?Direccion $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fecha_nacimiento): static
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getFechaFallecimiento(): ?\DateTimeInterface
    {
        return $this->fecha_fallecimiento;
    }

    public function setFechaFallecimiento(?\DateTimeInterface $fecha_fallecimiento): static
    {
        $this->fecha_fallecimiento = $fecha_fallecimiento;

        return $this;
    }

    public function getNif(): ?string
    {
        return $this->nif;
    }

    public function setNif(?string $nif): static
    {
        $this->nif = $nif;

        return $this;
    }

    public function getMadre(): ?self
    {
        return $this->madre;
    }

    public function setMadre(?self $madre): static
    {
        $this->madre = $madre;

        return $this;
    }

    public function addMadre(self $madre): static
    {
        if (!$this->madre->contains($madre)) {
            $this->madre->add($madre);
            $madre->setMadre($this);
        }

        return $this;
    }

    public function removeMadre(self $madre): static
    {
        if ($this->madre->removeElement($madre)) {
            // set the owning side to null (unless already changed)
            if ($madre->getMadre() === $this) {
                $madre->setMadre(null);
            }
        }

        return $this;
    }

    public function getPadre(): ?self
    {
        return $this->padre;
    }

    public function setPadre(?self $padre): static
    {
        $this->padre = $padre;

        return $this;
    }

    public function addPadre(self $padre): static
    {
        if (!$this->padre->contains($padre)) {
            $this->padre->add($padre);
            $padre->setPadre($this);
        }

        return $this;
    }

    public function removePadre(self $padre): static
    {
        if ($this->padre->removeElement($padre)) {
            // set the owning side to null (unless already changed)
            if ($padre->getPadre() === $this) {
                $padre->setPadre(null);
            }
        }

        return $this;
    }

    public function getTutor1(): ?self
    {
        return $this->tutor1;
    }

    public function setTutor1(?self $tutor1): static
    {
        $this->tutor1 = $tutor1;

        return $this;
    }

    public function addTutor1(self $tutor1): static
    {
        if (!$this->tutor1->contains($tutor1)) {
            $this->tutor1->add($tutor1);
            $tutor1->setTutor1($this);
        }

        return $this;
    }

    public function removeTutor1(self $tutor1): static
    {
        if ($this->tutor1->removeElement($tutor1)) {
            // set the owning side to null (unless already changed)
            if ($tutor1->getTutor1() === $this) {
                $tutor1->setTutor1(null);
            }
        }

        return $this;
    }

    public function getTutor2(): ?self
    {
        return $this->tutor2;
    }

    public function setTutor2(?self $tutor2): static
    {
        $this->tutor2 = $tutor2;

        return $this;
    }

    public function addTutor2(self $tutor2): static
    {
        if (!$this->tutor2->contains($tutor2)) {
            $this->tutor2->add($tutor2);
            $tutor2->setTutor2($this);
        }

        return $this;
    }

    public function removeTutor2(self $tutor2): static
    {
        if ($this->tutor2->removeElement($tutor2)) {
            // set the owning side to null (unless already changed)
            if ($tutor2->getTutor2() === $this) {
                $tutor2->setTutor2(null);
            }
        }

        return $this;
    }
}
