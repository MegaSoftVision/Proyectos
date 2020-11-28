<?php

namespace App\Entity;

use App\Repository\ValorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=ValorRepository::class)
 */
class Valor
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
     * @ORM\OneToMany(targetEntity=Seleccion::class, mappedBy="valor", cascade = "remove")
     */
    private $seleccions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity=Encuesta::class, inversedBy="valors")
     */
    private $encuesta;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriaValor::class, inversedBy="valors")
     */
    private $categoria;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="valors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     */
    private $date_create;

    public function __construct()
    {
      	$this->date_create = new \DateTime();
      	$this->descripcion = 'Nueva Seleccion';
        $this->seleccions = new ArrayCollection();
      	$this->color = '#1a2cbb';
       	$this->encuesta = new ArrayCollection();
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
     * @return Collection|Seleccion[]
     */
    public function getSeleccions(): Collection
    {
        return $this->seleccions;
    }

    public function addSeleccion(Seleccion $seleccion): self
    {
        if (!$this->seleccions->contains($seleccion)) {
            $this->seleccions[] = $seleccion;
            $seleccion->setValor($this);
        }

        return $this;
    }

    public function removeSeleccion(Seleccion $seleccion): self
    {
        if ($this->seleccions->contains($seleccion)) {
            $this->seleccions->removeElement($seleccion);
            // set the owning side to null (unless already changed)
            if ($seleccion->getValor() === $this) {
                $seleccion->setValor(null);
            }
        }

        return $this;
    }

   public function getColor(): ?string
   {
       return $this->color;
   }

   public function setColor(string $color): self
   {
       $this->color = $color;

       return $this;
   }

   public function __toString(): self
   {
     return $this->descripcion;
   }

   /**
    * @return Collection|Encuesta[]
    */
   public function getEncuesta(): Collection
   {
       return $this->encuesta;
   }

   public function addEncuestum(Encuesta $encuestum): self
   {
       if (!$this->encuesta->contains($encuestum)) {
           $this->encuesta[] = $encuestum;
       }

       return $this;
   }

   public function removeEncuestum(Encuesta $encuestum): self
   {
       if ($this->encuesta->contains($encuestum)) {
           $this->encuesta->removeElement($encuestum);
       }

       return $this;
   }

   public function getCategoria(): ?CategoriaValor
   {
       return $this->categoria;
   }

   public function setCategoria(?CategoriaValor $categoria): self
   {
       $this->categoria = $categoria;

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

   public function getDateCreate(): ?\DateTimeInterface
   {
       return $this->date_create;
   }

   public function setDateCreate(\DateTimeInterface $date_create): self
   {
       $this->date_create = $date_create;

       return $this;
   }
}
