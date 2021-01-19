<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     *@ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="NSC is required")
    */
    private $nsc;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     *
     */
    private $email;


    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class, inversedBy="students")
     *@Assert\NotBlank(message="classroom is required")
     */
    private $classroom;

    /**
     * @ORM\ManyToMany(targetEntity=Club::class, inversedBy="students")
     * @ORM\JoinTable(name="students_clubs",
     *      joinColumns={@ORM\JoinColumn(name="student_id", referencedColumnName="nsc")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="club_id", referencedColumnName="ref")}
     *      )
     */
    private $clubs;

    public function __construct()
    {
        $this->clubs = new ArrayCollection();
    }

   public function getNsc(): ?string
    {
        return $this->nsc;
    }

    public function setNsc(string $nsc): self
    {
        $this->nsc = $nsc;

        return $this;
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

    public function __toString()
    {
        return(string)$this->getEmail();
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * @return Collection|Club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        $this->clubs->removeElement($club);

        return $this;
    }
   }
