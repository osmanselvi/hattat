<?php

namespace App\Entity;

use App\Repository\SiteSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteSettingRepository::class)]
class SiteSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $heroTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $heroSubtitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $aboutText = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contactPhone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $socialInstagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $socialTwitter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeroTitle(): ?string
    {
        return $this->heroTitle;
    }

    public function setHeroTitle(?string $heroTitle): static
    {
        $this->heroTitle = $heroTitle;

        return $this;
    }

    public function getHeroSubtitle(): ?string
    {
        return $this->heroSubtitle;
    }

    public function setHeroSubtitle(?string $heroSubtitle): static
    {
        $this->heroSubtitle = $heroSubtitle;

        return $this;
    }

    public function getAboutText(): ?string
    {
        return $this->aboutText;
    }

    public function setAboutText(?string $aboutText): static
    {
        $this->aboutText = $aboutText;

        return $this;
    }

    public function getContactAddress(): ?string
    {
        return $this->contactAddress;
    }

    public function setContactAddress(?string $contactAddress): static
    {
        $this->contactAddress = $contactAddress;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(?string $contactPhone): static
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    public function getSocialInstagram(): ?string
    {
        return $this->socialInstagram;
    }

    public function setSocialInstagram(?string $socialInstagram): static
    {
        $this->socialInstagram = $socialInstagram;

        return $this;
    }

    public function getSocialTwitter(): ?string
    {
        return $this->socialTwitter;
    }

    public function setSocialTwitter(?string $socialTwitter): static
    {
        $this->socialTwitter = $socialTwitter;

        return $this;
    }
}
