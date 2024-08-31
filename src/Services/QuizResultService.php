<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\QuizzResult;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

class QuizResultService
{
    public function __construct(private readonly QuizRepository $quizRepo, private readonly EntityManagerInterface $em)
    {
    }

    public function add(Quiz $quiz, array $quizResultData)
    {
        $quizResult = new QuizzResult($quiz, $quizResultData);

        $this->em->persist($quizResult);
        $this->em->flush();

        return $quizResult;
    }
}
