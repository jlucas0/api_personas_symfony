<?php

namespace App\Entity;

use App\Repository\PoblacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PoblacionRepository::class)]
#[ORM\Table(name: 'poblaciones')]
class Poblacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'poblacion', targetEntity: CodigoPostal::class)]
    private Collection $codigoPostal;

    public function __construct()
    {
        $this->codigoPostal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * @return Collection<int, CodigoPostal>
     */
    public function getCodigoPostal(): Collection
    {
        return $this->codigoPostal;
    }

}
