<?php

namespace App\Controller\Frontend;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('', name: 'app.homepage', methods: ['GET'])]
    public function index(ArticlesRepository $articleRepo): Response
    {
        return $this->render('Frontend/Home/index.html.twig', [
            'articles' => $articleRepo->findLatestArticles(3),
        ]);
    }
}
