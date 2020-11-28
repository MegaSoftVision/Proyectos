<?php

namespace App\Entity;

use App\Repository\CategoriaEncuestaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=CategoriaEncuestaRepository::class)
 */
class CategoriaEncuesta
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
     * @ORM\Column(type="date")
     */
    private $date_create;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="categoriaEncuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Encuesta::class, mappedBy="categoria")
     */
    private $encuestas;

    /**
     * @ORM\OneToMany(targetEntity=Registro::class, mappedBy="categoria")
     */
    private $registros;

    public function __construct()
    {
      	 $this->date_create = new \DateTime();
        $this->encuestas = new ArrayCollection();
        $this->registros = new ArrayCollection();
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

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

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

    /**
     * @return Collection|Encuesta[]
     */
    public function getEncuestas(): Collection
    {
        return $this->encuestas;
    }

    public function addEncuesta(Encuesta $encuesta): self
    {
        if (!$this->encuestas->contains($encuesta)) {
            $this->encuestas[] = $encuesta;
            $encuesta->setCategoria($this);
        }

        return $this;
    }

    public function removeEncuesta(Encuesta $encuesta): self
    {
        if ($this->encuestas->contains($encuesta)) {
            $this->encuestas->removeElement($encuesta);
            // set the owning side to null (unless already changed)
            if ($encuesta->getCategoria() === $this) {
                $encuesta->setCategoria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Registro[]
     */
    public function getRegistros(): Collection
    {
        return $this->registros;
    }

    public function addRegistro(Registro $registro): self
    {
        if (!$this->registros->contains($registro)) {
            $this->registros[] = $registro;
            $registro->setCategoria($this);
        }

        return $this;
    }

    public function removeRegistro(Registro $registro): self
    {
        if ($this->registros->contains($registro)) {
            $this->registros->removeElement($registro);
            // set the owning side to null (unless already changed)
            if ($registro->getCategoria() === $this) {
                $registro->setCategoria(null);
            }
        }

        return $this;
    }
  	public function __toString(): self
   {
     return $this->descripcion;
   }
}
