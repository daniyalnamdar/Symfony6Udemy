<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MicroPostController extends AbstractController
{

    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $microPostRepository): Response
    {
//        $microPost = new MicroPost();
//        $microPost->setTitle('It is coming from Controller!');
//        $microPost->setText('Text from the controller!');
//        $microPost->setCreated(new \DateTime());

//        $microPost = $microPostRepository->find(4);
//        $microPost->setTitle('It is coming from Controller Edited!');
//
//        $microPost = $microPostRepository->find(4);
//        $microPostRepository->remove($microPost);
//
//        $microPostRepository->add($microPost, true);

        return $this->render('micro_post/index.html.twig', [
            'posts' => $microPostRepository->findAllWithComments(),
        ]);
    }

    #[Route('/micro-post/{microPost}', name: 'app_micro_post_show')]
    #[IsGranted(MicroPost::VIEW, 'microPost')]
    public function showOne(MicroPost $microPost): Response
    {

        return $this->render('micro_post/show.html.twig', [
            'post' => $microPost,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    #[IsGranted('ROLE_WRITER')]
    public function add(Request $request, MicroPostRepository $microPostRepository): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            $post->setAuthor($this->getUser());

            $microPostRepository->add($post);

            $this->addFlash('success', 'Your micro post has been added.');

            return $this->redirectToRoute('app_micro_post');
        }

        return $this->renderForm(
            'micro_post/add.html.twig', [
                'form' => $form
            ]
        );
    }

    #[Route('/micro-post/{microPost}/edit', name: 'app_micro_post_edit')]
    #[IsGranted(MicroPost::EDIT, 'microPost')]
    public function edit(Request $request, MicroPostRepository $microPostRepository, MicroPost $microPost): Response
    {


        $form = $this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();


            $microPostRepository->add($post);

            $this->addFlash('success', 'Your micro post has been updated!!.');

            return $this->redirectToRoute('app_micro_post');
        }

        return $this->renderForm(
            'micro_post/edit.html.twig', [
                'form' => $form,
                'post' =>$microPost
            ]
        );
    }

    #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
    #[IsGranted('ROLE_COMMENTER')]
    public function addComment(Request $request, CommentRepository $comments, MicroPost $post): Response
    {
        $form = $this->createForm(CommentType::class, new Comment());

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $comment = $form->getData();
            $comment->setMicroPost($post);
            $comment->setAuthor($this->getUser());
            $comments->add($comment);


            $this->addFlash('success', 'Your Comment has been created!!.');

            return $this->redirectToRoute(
                'app_micro_post_show',
                ['microPost' => $post->getId()]
            );
        }

        return $this->renderForm(
            'micro_post/comment.html.twig', [
                'form' => $form,
                'post' => $post
            ]
        );
    }

}
