<?php

namespace App\Controller;

use App\Entity\QuizzResult;
use App\Repository\QuizzResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizResultController extends AbstractController
{

    #[Route('/quizzes/result/{id}', name: 'app_quiz_result')]
    public function index(?QuizzResult $quizResult, $id, QuizzResultRepository $quizResultRepo): Response
    {
        $quizResult = $quizResultRepo->find($id);

        if (!$quizResult) {
            return $this->redirectToRoute('app_home');
        }


        return $this->render('quiz_result/index.html.twig', [
            'quizResult' => $quizResult,
        ]);
    }
}
