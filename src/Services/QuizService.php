<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use finfo;

class QuizService
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly QuizRepository $quizRepo)
    {
    }
    public function add(array $quizData)
    {
        $quiz = new Quiz($quizData['title']);

        foreach ($quizData['questions'] as $questionData) {
            $question = new Question($questionData['question']);
            $correctAnswer = $questionData['answer'];

            $this->em->persist($question);

            foreach ($questionData['answers'] as $key => $answerData) {
                $answer = new Answer($answerData);
                $answer->setIsCorrect(isCorrect: $correctAnswer == $answerData); //$key === array_search($correctAnswer, $questionData['anwsers'])
                $question->addAnswer($answer);

                $this->em->persist($answer);
            }

            $quiz->addQuestion($question);
        }

        $this->em->persist($quiz);
        $this->em->flush();

        return $quiz;
    }
}
