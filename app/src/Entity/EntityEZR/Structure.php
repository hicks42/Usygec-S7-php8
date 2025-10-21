<?php

namespace App\Entity\EntityEZR;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\RepositoryEZR\StructureRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass:StructureRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Structure
{
    use Timestampable;

    public function __toString()
    {
        return $this->name;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private $id;

    #[ORM\Column(type:"string", length:255)]
    private $name;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $imageName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="company_image_banner", fileNameProperty="imageName")
     * @Ignore()
     * @var File|null
     */
    #[Vich\UploadableField(mapping:"company_image_banner", fileNameProperty:"imageName")]
    #[Assert\Image(maxSize:"8M", maxSizeMessage:"Le fichier est trop gros")]
    private ?File $imageFile = null;

    #[ORM\Column(type:"string", length:255)]
    private $adresse1;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $adresse2;

    #[ORM\Column(type:"integer", nullable:true)]
    private $cp;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $city;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $country;

    #[ORM\Column(type:"string", length:255, nullable:true)]
    private $phone;

    #[ORM\ManyToOne(targetEntity:User::class, inversedBy:"structures")]
    #[ORM\JoinColumn(nullable:false)]
    private $user;

    #[ORM\Column(type:"string", nullable:true)]
    private $Pid;

    #[ORM\Column(type:"text", length:255, nullable:true)]
    private $badRevUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(?int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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

    public function getPid(): ?string
    {
        return $this->Pid;
    }

    public function setPid(?string $Pid): self
    {
        $this->Pid = $Pid;

        return $this;
    }

    public function getBadRevUrl(): ?string
    {
        return $this->badRevUrl;
    }

    public function setBadRevUrl(?string $badRevUrl): self
    {
        $this->badRevUrl = $badRevUrl;

        return $this;
    }

    /**
     * Génère l'URL Google pour laisser un avis (avec Place ID)
     * Cette URL ouvre directement le popup "Donner un avis" sur Google
     *
     * @return string|null L'URL complète ou null si pas de PID
     */
    public function getGoogleReviewUrl(): ?string
    {
        if (empty($this->Pid)) {
            return null;
        }

        return "https://search.google.com/local/writereview?placeid=" . $this->Pid;
    }

    /**
     * Génère un lien de fallback vers Google Maps (recherche par nom + adresse)
     * Ce lien fonctionne SANS Place ID et redirige vers la page Google Maps de l'établissement
     * L'utilisateur pourra ensuite cliquer sur "Avis" pour donner son avis
     *
     * @return string L'URL de recherche Google Maps
     */
    public function getGoogleFallbackUrl(): string
    {
        // Construire la requête de recherche avec les informations disponibles
        $parts = [];

        // Nom de l'établissement (obligatoire)
        if (!empty($this->name)) {
            $parts[] = $this->name;
        }

        // Adresse
        if (!empty($this->adresse1)) {
            $parts[] = $this->adresse1;
        }

        // Code postal
        if (!empty($this->cp)) {
            $parts[] = $this->cp;
        }

        // Ville
        if (!empty($this->city)) {
            $parts[] = $this->city;
        }

        // Pays (optionnel, pour éviter les ambiguïtés)
        if (!empty($this->country)) {
            $parts[] = $this->country;
        }

        // Construire la requête
        $query = implode(', ', $parts);

        // Encoder et générer l'URL Google Maps
        // Ce lien ouvre Google Maps avec la recherche pré-remplie
        // L'utilisateur verra l'établissement et pourra cliquer sur "Avis"
        return "https://www.google.com/maps/search/" . urlencode($query);
    }

    /**
     * Retourne l'URL optimale pour laisser un avis Google
     * Priorise le lien avec PID (direct vers formulaire d'avis)
     * Sinon utilise le lien fallback (recherche Google Maps)
     *
     * @return string L'URL pour laisser un avis
     */
    public function getBestGoogleReviewUrl(): string
    {
        // Si on a un PID, utiliser l'URL directe (optimal)
        if (!empty($this->Pid)) {
            return $this->getGoogleReviewUrl();
        }

        // Sinon, utiliser le lien fallback (recherche Google Maps)
        return $this->getGoogleFallbackUrl();
    }
}
