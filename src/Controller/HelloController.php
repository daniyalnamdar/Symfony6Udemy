<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    private array $messages = [
        ['message' => 'Hello', 'created'=> '2023/06/12'],
        ['message' => 'Hi', 'created'=> '2022/04/12'],
        ['message' => 'Bye!', 'created'=> '2021/05/12']
    ];


    #[Route('/hello/{limit<\d+>?3}', name: 'hello', methods: ['GET'])]
    public function index(int $limit): Response
    {
        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => $limit
            ]
        );
//        return new Response(implode(',', array_slice($this->messages, 0 , $limit)));
    }

    #[Route('/messages/{id<\d+>}', name: 'show_one', methods: ['GET'])]
    public function showOne($id): Response
    {
        return $this->render(
            'hello/show_one.html.twig',
            [
                'message' => $this->messages[$id]
            ]
        );

    }

}