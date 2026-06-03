<?php

namespace App\Entity;

use App\Repository\CorrectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CorrectionRepository::class)]
#[ORM\Table(name: '`corrections`')]
class Correction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $correctedImagePath = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $teacherNote = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $correctedAt = null;

    #[ORM\OneToOne(inversedBy: 'correction', targetEntity: Submission::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Submission $submission = null;

    public function __construct()
    {
        $this->correctedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getCorrectedImagePath(): ?string { return $this->correctedImagePath; }
    public function setCorrectedImagePath(string $correctedImagePath): static { $this->correctedImagePath = $correctedImagePath; return $this; }

    public function getTeacherNote(): ?string { return $this->teacherNote; }
    public function setTeacherNote(?string $teacherNote): static { $this->teacherNote = $teacherNote; return $this; }

    public function getCorrectedAt(): ?\DateTimeImmutable { return $this->correctedAt; }
    public function setCorrectedAt(\DateTimeImmutable $correctedAt): static { $this->correctedAt = $correctedAt; return $this; }

    public function getSubmission(): ?Submission { return $this->submission; }
    public function setSubmission(?Submission $submission): static { $this->submission = $submission; return $this; }
}
