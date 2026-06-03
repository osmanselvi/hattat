<?php

namespace App\Entity;

use App\Repository\SubmissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubmissionRepository::class)]
#[ORM\Table(name: '`submissions`')]
class Submission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $studentNote = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $submittedAt = null;

    #[ORM\ManyToOne(inversedBy: 'submissions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Assignment $assignment = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\OneToOne(mappedBy: 'submission', targetEntity: Correction::class, cascade: ['persist', 'remove'])]
    private ?Correction $correction = null;

    public function __construct()
    {
        $this->submittedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getImagePath(): ?string { return $this->imagePath; }
    public function setImagePath(string $imagePath): static { $this->imagePath = $imagePath; return $this; }

    public function getStudentNote(): ?string { return $this->studentNote; }
    public function setStudentNote(?string $studentNote): static { $this->studentNote = $studentNote; return $this; }

    public function getSubmittedAt(): ?\DateTimeImmutable { return $this->submittedAt; }
    public function setSubmittedAt(\DateTimeImmutable $submittedAt): static { $this->submittedAt = $submittedAt; return $this; }

    public function getAssignment(): ?Assignment { return $this->assignment; }
    public function setAssignment(?Assignment $assignment): static { $this->assignment = $assignment; return $this; }

    public function getStudent(): ?Student { return $this->student; }
    public function setStudent(?Student $student): static { $this->student = $student; return $this; }

    public function getCorrection(): ?Correction { return $this->correction; }
    public function setCorrection(?Correction $correction): static {
        $this->correction = $correction;
        if ($correction !== null && $correction->getSubmission() !== $this) {
            $correction->setSubmission($this);
        }
        return $this;
    }
}
