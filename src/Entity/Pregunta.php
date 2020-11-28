<?php

namespace App\Entity;

use App\Repository\PreguntaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PreguntaRepository::class)
 */
class Pregunta
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
     * @ORM\ManyToMany(targetEntity=Encuesta::class, mappedBy="pregunta")
     */
    private $encuestas;

    /**
     * @ORM\ManyToMany(targetEntity=Seleccion::class, inversedBy="preguntas",cascade = "remove")
     */
    private $seleccion;

    /**
     * @ORM\OneToMany(targetEntity=Respuesta::class, mappedBy="pregunta",cascade = "remove")
     */
    private $respuestas;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaSimple::class, mappedBy="pregunta",cascade = "remove")
     */
    private $respuestaSimples;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $posicion;

    /**
     * @ORM\OneToMany(targetEntity=Grupo::class, mappedBy="pregunta",cascade = "remove")
     */
    private $grupos;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaGrupo::class, mappedBy="pregunta")
     */
    private $respuestaGrupos;

    public function __construct()
    {
		$this->descripcion = "Coloca aqui tu descripcion";
        $this->encuestas = new ArrayCollection();
        $this->seleccion = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
        $this->respuestaSimples = new ArrayCollection();
        $this->grupos = new ArrayCollection();
        $this->respuestaGrupos = new ArrayCollection();
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
            $encuesta->addPreguntum($this);
        }

        return $this;
    }

    public function removeEncuesta(Encuesta $encuesta): self
    {
        if ($this->encuestas->contains($encuesta)) {
            $this->encuestas->removeElement($encuesta);
            $encuesta->removePreguntum($this);
        }

        return $this;
    }

    /**
     * @return Collection|Seleccion[]
     */
    public function getSeleccion(): Collection
    {
        return $this->seleccion;
    }

    public function addSeleccion(Seleccion $seleccion): self
    {
        if (!$this->seleccion->contains($seleccion)) {
            $this->seleccion[] = $seleccion;
        }

        return $this;
    }

    public function removeSeleccion(Seleccion $seleccion): self
    {
        if ($this->seleccion->contains($seleccion)) {
            $this->seleccion->removeElement($seleccion);
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
            $respuesta->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): self
    {
        if ($this->respuestas->contains($respuesta)) {
            $this->respuestas->removeElement($respuesta);
            // set the owning side to null (unless already changed)
            if ($respuesta->getPregunta() === $this) {
                $respuesta->setPregunta(null);
            }
        }

        return $this;
    }
	public function __toString()
                                                                   {
                                                                     return $this->descripcion;
                                                                   }

    /**
     * @return Collection|RespuestaSimple[]
     */
    public function getRespuestaSimples(): Collection
    {
        return $this->respuestaSimples;
    }

    public function addRespuestaSimple(RespuestaSimple $respuestaSimple): self
    {
        if (!$this->respuestaSimples->contains($respuestaSimple)) {
            $this->respuestaSimples[] = $respuestaSimple;
            $respuestaSimple->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuestaSimple(RespuestaSimple $respuestaSimple): self
    {
        if ($this->respuestaSimples->contains($respuestaSimple)) {
            $this->respuestaSimples->removeElement($respuestaSimple);
            // set the owning side to null (unless already changed)
            if ($respuestaSimple->getPregunta() === $this) {
                $respuestaSimple->setPregunta(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPosicion(): ?int
    {
        return $this->posicion;
    }

    public function setPosicion(int $posicion): self
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * @return Collection|Grupo[]
     */
    public function getGrupos(): Collection
    {
        return $this->grupos;
    }

    public function addGrupo(Grupo $grupo): self
    {
        if (!$this->grupos->contains($grupo)) {
            $this->grupos[] = $grupo;
            $grupo->setPregunta($this);
        }

        return $this;
    }

    public function removeGrupo(Grupo $grupo): self
    {
        if ($this->grupos->contains($grupo)) {
            $this->grupos->removeElement($grupo);
            // set the owning side to null (unless already changed)
            if ($grupo->getPregunta() === $this) {
                $grupo->setPregunta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RespuestaGrupo[]
     */
    public function getRespuestaGrupos(): Collection
    {
        return $this->respuestaGrupos;
    }

    public function addRespuestaGrupo(RespuestaGrupo $respuestaGrupo): self
    {
        if (!$this->respuestaGrupos->contains($respuestaGrupo)) {
            $this->respuestaGrupos[] = $respuestaGrupo;
            $respuestaGrupo->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuestaGrupo(RespuestaGrupo $respuestaGrupo): self
    {
        if ($this->respuestaGrupos->contains($respuestaGrupo)) {
            $this->respuestaGrupos->removeElement($respuestaGrupo);
            // set the owning side to null (unless already changed)
            if ($respuestaGrupo->getPregunta() === $this) {
                $respuestaGrupo->setPregunta(null);
            }
        }

        return $this;
    }
}
