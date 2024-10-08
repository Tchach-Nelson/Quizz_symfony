<?php

namespace App\Entity;

use App\Repository\QuizzResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizzResultRepository::class)]
class QuizzResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quizResult:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizzResults')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['quizResult:read'])]
    private ?Quiz $quizz = null;

    #[ORM\Column]
    #[Groups(['quizResult:read'])]
    private array $results = [];

    public function __construct(Quiz $quiz, array $results)
    {
        $this->quizz = $quiz;
        $this->results = $results;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizz(): ?quiz
    {
        return $this->quizz;
    }

    public function setQuizz(?quiz $quizz): static
    {
        $this->quizz = $quizz;

        return $this;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): static
    {
        $this->results = $results;

        return $this;
    }
}
