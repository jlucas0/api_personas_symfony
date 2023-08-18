<?php

namespace App\Entity;

use App\Repository\CodigoPostalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodigoPostalRepository::class)]
#[ORM\Table(name: 'codigos_postales')]
class CodigoPostal
{
    #[ORM\Id]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $codigo = null;

    #[ORM\ManyToOne(inversedBy: 'codigoPostal')]
    #[ORM\JoinColumn(name:"poblacion",nullable: false)]
    private ?Poblacion $poblacion = null;

    #[ORM\OneToMany(mappedBy: 'codigo_postal', targetEntity: Direccion::class)]
    private Collection $direcciones;

    public function __construct()
    {
        $this->direcciones = new ArrayCollection();
    }

    public function getPoblacion(): ?Poblacion
    {
        return $this->poblacion;
    }

    public function getCodigo(): ?int
    {
        return $this->codigo;
    }

    /**
     * @return Collection<int, Direccion>
     */
    public function getDirecciones(): Collection
    {
        return $this->direcciones;
    }

    public function addDireccione(Direccion $direccione): static
    {
        if (!$this->direcciones->contains($direccione)) {
            $this->direcciones->add($direccione);
            $direccione->setCodigoPostal($this);
        }

        return $this;
    }

    public function removeDireccione(Direccion $direccione): static
    {
        if ($this->direcciones->removeElement($direccione)) {
            // set the owning side to null (unless already changed)
            if ($direccione->getCodigoPostal() === $this) {
                $direccione->setCodigoPostal(null);
            }
        }

        return $this;
    }

}
