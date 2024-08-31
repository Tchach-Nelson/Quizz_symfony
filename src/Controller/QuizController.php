<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\QuizzResult;
use App\Repository\QuizRepository;
use App\Service\QuizService;
use App\Service\QuizResultService;
use OpenAI\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    public function __construct(private readonly QuizService $quizService, private readonly QuizResultService $quizResultService, private readonly QuizRepository $quizRepo)
    {
    }

    #[Route('/quizzes', name: 'app_quizzes_add', methods: ['POST'])]
    public function add(Client $client, Request $request): Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->json([
                "error" => 'Method not allowed'
            ]);
        }

        $body = json_decode($request->getContent(), true);

        if (!isset($body['content'])) {
            return $this->json([
                "error" => 'Missing content'
            ]);
        }

        $content = "Rédige un quizz de 5 questions avec un titre et 3 réponses par questions portant sur le sujet '{$body['content']}' au format JSON. Les proprietés utilisées sont 'anwser' ,'anwers' et 'question'. ";

        $content = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'content' => $content,
                    'role' => 'user'
                ]
            ]
        ])['choices'][0]['message']['content'];

        $quizData = json_decode($content, true);

        // dd($quizData);
        $quiz = $this->quizService->add($quizData);

        return $this->json([
            'quiz' => [
                'id' => $quiz->getId()
            ]
        ]);
    }

    #[Route('/quizzes/{id}', name: 'app_quizzes_show')]
    public function show(Quiz $quiz, $id, Request $request): Response
    {
        $quiz = $this->quizRepo->find($id);

        if (!$quiz) {
            return $this->redirectToRoute('app_home');
        }

        if ($request->isXmlHttpRequest() && $request->isMethod(Request::METHOD_POST)) {
            $body = json_decode($request->getContent(), true);

            if (!isset($body['quizResult'])) {
                return $this->json([
                    'error' => 'Missing quizResult'
                ]);
            }

            $quizResult =  $this->quizResultService->add($quiz, $body['quizResult']);

            return $this->json([
                'quizResult' => [
                    'id' => $quizResult->getId()
                ]
            ]);
        }



        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz
        ]);
    }
}
