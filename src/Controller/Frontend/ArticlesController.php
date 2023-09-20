<?php

namespace App\Controller\Frontend;

use App\Repository\UserRepository;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/articles', name: 'app.articles')]
class ArticlesController extends AbstractController
{
    public function __construct(
        private ArticlesRepository $repoArticle,
        private UserRepository $repoUser,

    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        $users =  $this->repoUser->findAll();
        $articles = $this->repoArticle->findAll();

        return $this->render('Frontend/Articles/index.html.twig', [
            'articles' => $articles,
            'users' => $users,
        ]);
    }
}
