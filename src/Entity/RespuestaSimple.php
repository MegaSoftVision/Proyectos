<?php

namespace App\Entity;

use App\Repository\RespuestaSimpleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RespuestaSimpleRepository::class)
 */
class RespuestaSimple
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Registro::class, inversedBy="respuestaSimples")
     */
    private $registro;

    /**
     * @ORM\ManyToOne(targetEntity=Encuesta::class, inversedBy="respuestaSimples")
     */
    private $encuesta;

    /**
     * @ORM\ManyToOne(targetEntity=Pregunta::class, inversedBy="respuestaSimples")
     */
    private $pregunta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
