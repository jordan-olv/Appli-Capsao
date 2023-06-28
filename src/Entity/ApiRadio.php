<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ApiRadioRepository;
use ApiPlatform\Metadata\GetCollection;

#[ORM\Entity(repositoryClass: ApiRadioRepository::class)]
#[ApiResource(
    operations:[
        new Get(),
        new GetCollection(),
    ]
)]
class ApiRadio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 200)]
    private ?string $fluxAudio = null;

    #[ORM\Column(length: 200)]
    private ?string $fluxTxt = null;

    #[ORM\Column(length: 6)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 50,nullable:true)]
    private ?string $coordonnees = null;

    #[ORM\Column(nullable:true)]
    private ?int $rayon;

    #[ORM\Column]
    private ?bool $isDefault = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    public function __construct(){
        $this->setIsDefault('0');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getFluxAudio(): ?string
    {
        return $this->fluxAudio;
    }

    public function setFluxAudio(string $fluxAudio): self
    {
        $this->fluxAudio = $fluxAudio;

        return $this;
    }

    public function getFluxTxt(): ?string
    {
        return $this->fluxTxt;
    }

    public function setFluxTxt(string $fluxTxt): self
    {
        $this->fluxTxt = $fluxTxt;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCoordonnees(): ?string
    {
        return $this->coordonnees;
    }

    public function setCoordonnees(string $coordonnees): self
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    public function getRayon(): ?int
    {
        return $this->rayon;
    }

    public function setRayon(int $rayon): self
    {
        $this->rayon = $rayon;

        return $this;
    }

    public function isIsDefault(): ?bool
    {
        return $this->isDefault;
    }

    public function setIsDefault(bool $isDefault): self
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
