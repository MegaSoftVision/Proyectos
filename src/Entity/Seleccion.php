<?php

namespace App\Entity;

use App\Repository\SeleccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeleccionRepository::class)
 */
class Seleccion
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
     * @ORM\ManyToOne(targetEntity=Valor::class, inversedBy="seleccions")
     */
    private $valor;

    /**
     * @ORM\ManyToMany(targetEntity=Pregunta::class, mappedBy="seleccion")
     */
    private $preguntas;

    /**
     * @ORM\OneToMany(targetEntity=Respuesta::class, mappedBy="seleccion", cascade = "remove")
     */
    private $respuestas;

    public function __construct()
    {
        $this->preguntas = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
      	$this->descripcion = 'Nueva Seleccion';
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

    public function getValor(): ?Valor
    {
        return $this->valor;
    }

    public function setValor(?Valor $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * @return Collection|Pregunta[]
     */
    public function getPreguntas(): Collection
    {
        return $this->preguntas;
    }

    public function addPregunta(Pregunta $pregunta): self
    {
        if (!$this->preguntas->contains($pregunta)) {
            $this->preguntas[] = $pregunta;
            $pregunta->addSeleccion($this);
        }

        return $this;
    }

    public function removePregunta(Pregunta $pregunta): self
    {
        if ($this->preguntas->contains($pregunta)) {
            $this->preguntas->removeElement($pregunta);
            $pregunta->removeSeleccion($this);
        }

        return $this;
    }

    /**
     * @return Collection|Respuesta[]
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuesta $respuesta): self
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas[] = $respuesta;
            $respuesta->setSeleccion($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): self
    {
        if ($this->respuestas->contains($respuesta)) {
            $this->respuestas->removeElement($respuesta);
            // set the owning side to null (unless already changed)
            if ($respuesta->getSeleccion() === $this) {
                $respuesta->setSeleccion(null);
            }
        }

        return $this;
    }
}
