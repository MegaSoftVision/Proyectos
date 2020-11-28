<?php

namespace App\Entity;

use App\Repository\EncuestaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=EncuestaRepository::class)
 */
class Encuesta
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
     * @ORM\ManyToMany(targetEntity=Pregunta::class, inversedBy="encuestas", cascade = "remove")
     * @ORM\OrderBy({"posicion" = "ASC"})
     */
    private $pregunta;

    /**
     * @ORM\OneToMany(targetEntity=Respuesta::class, mappedBy="encuesta", cascade = "remove")
     */
    private $respuestas;

    /**
     * @ORM\OneToMany(targetEntity=Registro::class, mappedBy="encuesta", cascade = "remove")
     */
    private $registros;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaSimple::class, mappedBy="encuesta")
     */
    private $respuestaSimples;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="encuestas")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=RespuestaGrupo::class, mappedBy="encuesta")
     */
    private $respuestaGrupos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $banner;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $background;

    /**
     * @ORM\Column(type="string", length=9999, nullable=true)
     */
    private $instructivo;

    /**
     * @ORM\ManyToMany(targetEntity=Valor::class, mappedBy="encuesta")
     */
    private $valors;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriaEncuesta::class, inversedBy="encuestas")
     */
    private $categoria;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    public function __construct()
    {
		    $this->date_create = new \DateTime();
        $this->pregunta = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
        $this->registros = new ArrayCollection();
        $this->respuestaSimples = new ArrayCollection();
        $this->respuestaGrupos = new ArrayCollection();
      	$this->background = '#ffffff';
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

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    /**
     * @return Collection|Pregunta[]
     */
    public function getPregunta(): Collection
    {
        return $this->pregunta;
    }

    public function addPreguntum(Pregunta $preguntum): self
    {
        if (!$this->pregunta->contains($preguntum)) {
            $this->pregunta[] = $preguntum;
        }

        return $this;
    }

    public function removePreguntum(Pregunta $preguntum): self
    {
        if ($this->pregunta->contains($preguntum)) {
            $this->pregunta->removeElement($preguntum);
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
            $respuesta->setEncuesta($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): self
    {
        if ($this->respuestas->contains($respuesta)) {
            $this->respuestas->removeElement($respuesta);
            // set the owning side to null (unless already changed)
            if ($respuesta->getEncuesta() === $this) {
                $respuesta->setEncuesta(null);
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
            $registro->setEncuesta($this);
        }

        return $this;
    }

    public function removeRegistro(Registro $registro): self
    {
        if ($this->registros->contains($registro)) {
            $this->registros->removeElement($registro);
            // set the owning side to null (unless already changed)
            if ($registro->getEncuesta() === $this) {
                $registro->setEncuesta(null);
            }
        }

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
            $respuestaSimple->setEncuesta($this);
        }

        return $this;
    }

    public function removeRespuestaSimple(RespuestaSimple $respuestaSimple): self
    {
        if ($this->respuestaSimples->contains($respuestaSimple)) {
            $this->respuestaSimples->removeElement($respuestaSimple);
            // set the owning side to null (unless already changed)
            if ($respuestaSimple->getEncuesta() === $this) {
                $respuestaSimple->setEncuesta(null);
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
            $respuestaGrupo->setEncuesta($this);
        }

        return $this;
    }

    public function removeRespuestaGrupo(RespuestaGrupo $respuestaGrupo): self
    {
        if ($this->respuestaGrupos->contains($respuestaGrupo)) {
            $this->respuestaGrupos->removeElement($respuestaGrupo);
            // set the owning side to null (unless already changed)
            if ($respuestaGrupo->getEncuesta() === $this) {
                $respuestaGrupo->setEncuesta(null);
            }
        }

        return $this;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getInstructivo(): ?string
    {
        return $this->instructivo;
    }

    public function setInstructivo(?string $instructivo): self
    {
        $this->instructivo = $instructivo;

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
            $valor->addEncuestum($this);
        }

        return $this;
    }

    public function removeValor(Valor $valor): self
    {
        if ($this->valors->contains($valor)) {
            $this->valors->removeElement($valor);
            $valor->removeEncuestum($this);
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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
