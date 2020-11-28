<?php

namespace App\Entity;

use App\Repository\RegistroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegistroRepository::class)
 */
class Registro
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pais;

    /**
     * @ORM\OneToMany(targetEntity=Respuesta::class, mappedBy="registro",cascade = "remove")
     */
    private $respuestas;

    /**
     * @ORM\ManyToOne(targetEntity=Encuesta::class, inversedBy="registros")
     */
    private $encuesta;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaSimple::class, mappedBy="registro", cascade = "remove")
     */
    private $respuestaSimples;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaGrupo::class, mappedBy="registro",cascade = "remove")
     */
    private $respuestaGrupos;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriaEncuesta::class, inversedBy="registros")
     */
    private $categoria;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
        $this->respuestaSimples = new ArrayCollection();
        $this->respuestaGrupos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

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
            $respuesta->setRegistro($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): self
    {
        if ($this->respuestas->contains($respuesta)) {
            $this->respuestas->removeElement($respuesta);
            // set the owning side to null (unless already changed)
            if ($respuesta->getRegistro() === $this) {
                $respuesta->setRegistro(null);
            }
        }

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
            $respuestaSimple->setRegistro($this);
        }

        return $this;
    }

    public function removeRespuestaSimple(RespuestaSimple $respuestaSimple): self
    {
        if ($this->respuestaSimples->contains($respuestaSimple)) {
            $this->respuestaSimples->removeElement($respuestaSimple);
            // set the owning side to null (unless already changed)
            if ($respuestaSimple->getRegistro() === $this) {
                $respuestaSimple->setRegistro(null);
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
            $respuestaGrupo->setRegistro($this);
        }

        return $this;
    }

    public function removeRespuestaGrupo(RespuestaGrupo $respuestaGrupo): self
    {
        if ($this->respuestaGrupos->contains($respuestaGrupo)) {
            $this->respuestaGrupos->removeElement($respuestaGrupo);
            // set the owning side to null (unless already changed)
            if ($respuestaGrupo->getRegistro() === $this) {
                $respuestaGrupo->setRegistro(null);
            }
        }

        return $this;
    }

    public function getCategoria(): ?CategoriaEncuesta
    {
        return $this->categoria;
    }

    public function setCategoria(?CategoriaEncuesta $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}
