<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
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

//    #[Route('/', name: 'user_profile', methods: ['GET'])]
//    public function userProfile(EntityManagerInterface $om, MicroPostRepository $repository): Response
//    {
//        $post = $repository->find(10);
//        dd($post);
//        $post = new MicroPost();
//        $post->setTitle('Hello there');
//        $post->setText('Text for Hello');
//        $post->setCreated(new \DateTime());
//
//        $comment = new Comment();
//        $comment->setText('Hello');
//
//        $post->addComment($comment);
//        $om->persist($post);
//        $om->flush();

//        $user = new User();
//        $user->setEmail('emailww@gmail.com');
//        $user->setPassword('123456');
//
//        $profile = new UserProfile();
//        $profile->setUser($user);
//        $om->persist($profile);
//
//
//        $om->flush();

//        $profile = $repository->find(1);
//        $om->remove($profile);
//        $om->flush();

//        return $this->render(
//            'hello/show_one.html.twig',
//            [
//                'message' => 's'
//            ]
//        );
//
//    }


}