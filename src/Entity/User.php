<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Encuesta::class, mappedBy="useruser")
     */
    private $encuestas;

    /**
     * @ORM\OneToMany(targetEntity=CategoriaEncuesta::class, mappedBy="user", orphanRemoval=true)
     */
    private $categoriaEncuestas;

    /**
     * @ORM\OneToMany(targetEntity=Valor::class, mappedBy="user", orphanRemoval=true)
     */
    private $valors;

    /**
     * @ORM\OneToMany(targetEntity=CategoriaValor::class, mappedBy="user", orphanRemoval=true)
     */
    private $categoriaValors;

    public function __construct()
    {
        $this->encuestas = new ArrayCollection();
        $this->categoriaEncuestas = new ArrayCollection();
        $this->valors = new ArrayCollection();
        $this->categoriaValors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $encuesta->setUseruser($this);
        }

        return $this;
    }

    public function removeEncuesta(Encuesta $encuesta): self
    {
        if ($this->encuestas->contains($encuesta)) {
            $this->encuestas->removeElement($encuesta);
            // set the owning side to null (unless already changed)
            if ($encuesta->getUseruser() === $this) {
                $encuesta->setUseruser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CategoriaEncuesta[]
     */
    public function getCategoriaEncuestas(): Collection
    {
        return $this->categoriaEncuestas;
    }

    public function addCategoriaEncuesta(CategoriaEncuesta $categoriaEncuesta): self
    {
        if (!$this->categoriaEncuestas->contains($categoriaEncuesta)) {
            $this->categoriaEncuestas[] = $categoriaEncuesta;
            $categoriaEncuesta->setUser($this);
        }

        return $this;
    }

    public function removeCategoriaEncuesta(CategoriaEncuesta $categoriaEncuesta): self
    {
        if ($this->categoriaEncuestas->contains($categoriaEncuesta)) {
            $this->categoriaEncuestas->removeElement($categoriaEncuesta);
            // set the owning side to null (unless already changed)
            if ($categoriaEncuesta->getUser() === $this) {
                $categoriaEncuesta->setUser(null);
            }
        }

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
            $valor->setUser($this);
        }

        return $this;
    }

    public function removeValor(Valor $valor): self
    {
        if ($this->valors->contains($valor)) {
            $this->valors->removeElement($valor);
            // set the owning side to null (unless already changed)
            if ($valor->getUser() === $this) {
                $valor->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CategoriaValor[]
     */
    public function getCategoriaValors(): Collection
    {
        return $this->categoriaValors;
    }

    public function addCategoriaValor(CategoriaValor $categoriaValor): self
    {
        if (!$this->categoriaValors->contains($categoriaValor)) {
            $this->categoriaValors[] = $categoriaValor;
            $categoriaValor->setUser($this);
        }

        return $this;
    }

    public function removeCategoriaValor(CategoriaValor $categoriaValor): self
    {
        if ($this->categoriaValors->contains($categoriaValor)) {
            $this->categoriaValors->removeElement($categoriaValor);
            // set the owning side to null (unless already changed)
            if ($categoriaValor->getUser() === $this) {
                $categoriaValor->setUser(null);
            }
        }

        return $this;
    }
}
