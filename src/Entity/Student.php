<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table(name: '`students`')]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'student', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 20)]
    private ?string $level = 'başlangıç'; // başlangıç, orta, ileri

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $enrollmentDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Assignment::class)]
    private Collection $assignments;

    public function __construct()
    {
        $this->enrollmentDate = new \DateTime();
        $this->assignments = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): static { $this->phone = $phone; return $this; }

    public function getLevel(): ?string { return $this->level; }
    public function setLevel(string $level): static { $this->level = $level; return $this; }

    public function getEnrollmentDate(): ?\DateTimeInterface { return $this->enrollmentDate; }
    public function setEnrollmentDate(\DateTimeInterface $enrollmentDate): static { $this->enrollmentDate = $enrollmentDate; return $this; }

    public function getNotes(): ?string { return $this->notes; }
    public function setNotes(?string $notes): static { $this->notes = $notes; return $this; }

    public function getAssignments(): Collection { return $this->assignments; }
    public function __toString(): string { return $this->user ? $this->user->getName() : 'New Student'; }
}
