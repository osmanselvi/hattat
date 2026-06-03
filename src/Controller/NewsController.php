<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/haberler', name: 'app_news')]
    public function index(EntityManagerInterface $em): Response
    {
        $newsList = $em->getRepository(News::class)->findBy(
            ['isPublished' => true],
            ['publishedAt' => 'DESC']
        );

        return $this->render('news/index.html.twig', [
            'newsList' => $newsList,
        ]);
    }

    #[Route('/haberler/{slug}', name: 'app_news_detail')]
    public function detail(News $news): Response
    {
        if (!$news->isPublished()) {
            throw $this->createNotFoundException('Haber bulunamadı.');
        }

        return $this->render('news/detail.html.twig', [
            'news' => $news,
        ]);
    }
}
