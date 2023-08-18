<?php

namespace App\Entity;

use App\Repository\DireccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DireccionRepository::class)]
#[ORM\Table(name: 'direcciones')]
class Direccion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(
        message: 'La calle es obligatoria',
    )]
    #[Assert\Length(
        max:150,
        maxMessage: 'Máximo 150 caracteres para la calle'
    )]
    #[ORM\Column(length: 150)]
    private ?string $calle = null;

    #[Assert\NotBlank(
        message: 'El número es obligatorio',
    )]
    #[Assert\Length(
        max:10,
        maxMessage: 'Máximo 10 caracteres para el número'
    )]
    #[ORM\Column(length: 10)]
    private ?string $numero = null;

    #[Assert\Length(
        max:10,
        maxMessage: 'Máximo 50 caracteres para el resto de datos'
    )]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $resto_datos = null;

    #[Assert\NotBlank(
        message: 'El código postal es obligatorio y debe existir',
    )]
    #[ORM\ManyToOne(inversedBy: 'direcciones')]
    #[ORM\JoinColumn(name:"codigo_postal",referencedColumnName:"codigo",nullable: false)]
    private ?CodigoPostal $codigo_postal = null;

    #[ORM\OneToMany(mappedBy: 'direccion', targetEntity: Persona::class)]
    private Collection $personas;

    public function __construct()
    {
        $this->personas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(?string $calle): static
    {
        $this->calle = $calle;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getRestoDatos(): ?string
    {
        return $this->resto_datos;
    }

    public function setRestoDatos(?string $resto_datos): static
    {
        $this->resto_datos = $resto_datos;

        return $this;
    }

    public function getCodigoPostal(): ?CodigoPostal
    {
        return $this->codigo_postal;
    }

    public function setCodigoPostal(?CodigoPostal $codigo_postal): static
    {
        $this->codigo_postal = $codigo_postal;

        return $this;
    }

    /**
     * @return Collection<int, Persona>
     */
    public function getPersonas(): Collection
    {
        return $this->personas;
    }

    public function addPersona(Persona $persona): static
    {
        if (!$this->personas->contains($persona)) {
            $this->personas->add($persona);
            $persona->setDireccion($this);
        }

        return $this;
    }

    public function removePersona(Persona $persona): static
    {
        if ($this->personas->removeElement($persona)) {
            // set the owning side to null (unless already changed)
            if ($persona->getDireccion() === $this) {
                $persona->setDireccion(null);
            }
        }

        return $this;
    }
}
