<?php

namespace App\Controller\Backend;

use App\Entity\Articles;
use App\Form\ArticleType;
use App\Repository\UserRepository;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/articles', name: 'admin.articles')]
class ArticlesController extends AbstractController
{
    public function __construct(
        private ArticlesRepository $repoArticle,
        private UserRepository $repoUser,
        private Security $security

    ) {
    }

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(): Response
    {
        $users =  $this->repoUser->findAll();
        $articles = $this->repoArticle->findAll();

        return $this->render('Backend/Articles/index.html.twig', [
            'articles' => $articles,
            'users' => $users,
        ]);
    }

    #[Route('/create', name: '.create')]
    public function createArticle(Request $request)
    {
        $article = new Articles();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setUser($this->security->getUser());
            $this->repoArticle->save($article);
            $this->addFlash('success', 'Article créé avec succès');

            return $this->redirectToRoute('admin.articles.index');
        }
        return $this->render('Backend/Articles/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: '.edit', methods: 'GET|POST')]
    public function editArticle(Articles $article, Request $request)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repoArticle->save($article, true);
            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('admin.articles.index');
        }
        return $this->render('Backend/Articles/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
