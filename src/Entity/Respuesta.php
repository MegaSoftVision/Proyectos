<?php

namespace App\Entity;

use App\Repository\RespuestaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RespuestaRepository::class)
 */
class Respuesta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Registro::class, inversedBy="respuestas")
     */
    private $registro;

    /**
     * @ORM\ManyToOne(targetEntity=Encuesta::class, inversedBy="respuestas")
     */
    private $encuesta;

    /**
     * @ORM\ManyToOne(targetEntity=Pregunta::class, inversedBy="respuestas")
     */
    private $pregunta;

    /**
     * @ORM\ManyToOne(targetEntity=Seleccion::class, inversedBy="respuestas")
     */
    private $seleccion;

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

    public function getSeleccion(): ?Seleccion
    {
        return $this->seleccion;
    }

    public function setSeleccion(?Seleccion $seleccion): self
    {
        $this->seleccion = $seleccion;

        return $this;
    }
}
