<?php

namespace App\Entity;

use App\Repository\GrupoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GrupoRepository::class)
 */
class Grupo
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
     * @ORM\ManyToOne(targetEntity=Pregunta::class, inversedBy="grupos")
     */
    private $pregunta;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaGrupo::class, mappedBy="grupo",cascade = "remove")
     */
    private $respuestaGrupos;

    public function __construct()
    {
        $this->respuestaGrupos = new ArrayCollection();
      	$this->descripcion = 'Nuevo Grupo';
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

    public function getPregunta(): ?Pregunta
    {
        return $this->pregunta;
    }

    public function setPregunta(?Pregunta $pregunta): self
    {
        $this->pregunta = $pregunta;

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
            $respuestaGrupo->setGrupo($this);
        }

        return $this;
    }

    public function removeRespuestaGrupo(RespuestaGrupo $respuestaGrupo): self
    {
        if ($this->respuestaGrupos->contains($respuestaGrupo)) {
            $this->respuestaGrupos->removeElement($respuestaGrupo);
            // set the owning side to null (unless already changed)
            if ($respuestaGrupo->getGrupo() === $this) {
                $respuestaGrupo->setGrupo(null);
            }
        }

        return $this;
    }
}
