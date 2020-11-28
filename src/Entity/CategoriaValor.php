<?php

namespace App\Entity;

use App\Repository\CategoriaValorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaValorRepository::class)
 */
class CategoriaValor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=Valor::class, mappedBy="categoria")
     */
    private $valors;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="categoriaValors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->valors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|Valor[]
     */
    public function getValors(): Collection
    {
        return $this->valors;
    }

    public function addValor(Valor $valor): self
    {
        if (!$this->valors->contains($valor)) {
            $this->valors[] = $valor;
            $valor->setCategoria($this);
        }

        return $this;
    }

    public function removeValor(Valor $valor): self
    {
        if ($this->valors->contains($valor)) {
            $this->valors->removeElement($valor);
            // set the owning side to null (unless already changed)
            if ($valor->getCategoria() === $this) {
                $valor->setCategoria(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
