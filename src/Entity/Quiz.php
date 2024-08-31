<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['quiz:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['quiz:read', 'quizResult:read'])]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'quizz', targetEntity: Question::class)]
    #[Groups(['quiz:read', 'quizResult:read'])]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'quizz', targetEntity: QuizzResult::class)]
    private Collection $quizzResults;

    public function __construct(?string $title = null)
    {
        $this->questions = new ArrayCollection();
        $this->quizzResults = new ArrayCollection();
        $this->title = $title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuizz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuizz() === $this) {
                $question->setQuizz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuizzResult>
     */
    public function getQuizzResults(): Collection
    {
        return $this->quizzResults;
    }

    public function addQuizzResult(QuizzResult $quizzResult): static
    {
        if (!$this->quizzResults->contains($quizzResult)) {
            $this->quizzResults->add($quizzResult);
            $quizzResult->setQuizz($this);
        }

        return $this;
    }

    public function removeQuizzResult(QuizzResult $quizzResult): static
    {
        if ($this->quizzResults->removeElement($quizzResult)) {
            // set the owning side to null (unless already changed)
            if ($quizzResult->getQuizz() === $this) {
                $quizzResult->setQuizz(null);
            }
        }

        return $this;
    }
}
