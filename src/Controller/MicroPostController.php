<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            'posts' => $microPostRepository->findAll(),
        ]);
    }

    #[Route('/micro-post/{microPost}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $microPost): Response
    {

        return $this->render('micro_post/show.html.twig', [
            'post' => $microPost,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, MicroPostRepository $microPostRepository): Response
    {
        $microPost = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $microPost);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $post = $form->getData();
            $post->setCreated(new \DateTime());

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
                'form' => $form
            ]
        );
    }


}
