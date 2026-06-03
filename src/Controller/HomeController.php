<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Entity\Exhibition;
use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em): Response
    {
        $featuredArtworks = $em->getRepository(Artwork::class)->findBy(
            ['isFeatured' => true],
            ['createdAt' => 'DESC'],
            3
        );

        $heroArtwork = $em->getRepository(Artwork::class)->findOneBy(
            ['isHeroBackground' => true],
            ['createdAt' => 'DESC']
        );

        $upcomingExhibitions = $em->getRepository(Exhibition::class)->findBy(
            ['isActive' => true],
            ['startDate' => 'ASC'],
            3
        );

        $latestNews = $em->getRepository(News::class)->findBy(
            ['isPublished' => true],
            ['publishedAt' => 'DESC'],
            3
        );

        return $this->render('home/index.html.twig', [
            'featuredArtworks' => $featuredArtworks,
            'upcomingExhibitions' => $upcomingExhibitions,
            'latestNews' => $latestNews,
            'heroArtwork' => $heroArtwork,
        ]);
    }
}
