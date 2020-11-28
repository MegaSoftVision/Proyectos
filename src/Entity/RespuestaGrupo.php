<?php

namespace App\Entity;

use App\Repository\RespuestaGrupoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RespuestaGrupoRepository::class)
 */
class RespuestaGrupo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Registro::class, inversedBy="respuestaGrupos")
     */
    private $registro;

    /**
     * @ORM\ManyToOne(targetEntity=Encuesta::class, inversedBy="respuestaGrupos")
     */
    private $encuesta;

    /**
     * @ORM\ManyToOne(targetEntity=Pregunta::class, inversedBy="respuestaGrupos")
     */
    private $pregunta;

    /**
     * @ORM\ManyToOne(targetEntity=Grupo::class, inversedBy="respuestaGrupos")
     */
    private $grupo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistro(): ?Registro
    {
        return $this->registro;
    }

    public function setRegistro(?Registro $registro): self
    {
        $this->registro = $registro;

        return $this;
    }

    public function getEncuesta(): ?Encuesta
    {
        return $this->encuesta;
    }

    public function setEncuesta(?Encuesta $encuesta): self
    {
        $this->encuesta = $encuesta;

        return $this;
    }

    public function getPregunta(): ?Pregunta
    {
        return $this->pregunta;
    }

    public function setPregunta(?Pregunta $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getGrupo(): ?Grupo
    {
        return $this->grupo;
    }

    public function setGrupo(?Grupo $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }
}
