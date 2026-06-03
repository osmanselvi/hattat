<?php

namespace App\Controller;

use App\Entity\Exhibition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExhibitionController extends AbstractController
{
    #[Route('/sergiler', name: 'app_exhibitions')]
    public function index(EntityManagerInterface $em): Response
    {
        $activeExhibitions = $em->getRepository(Exhibition::class)->findBy(
            ['isActive' => true],
            ['startDate' => 'ASC']
        );
        
        $pastExhibitions = $em->getRepository(Exhibition::class)->findBy(
            ['isActive' => false],
            ['endDate' => 'DESC']
        );

        return $this->render('exhibition/index.html.twig', [
            'activeExhibitions' => $activeExhibitions,
            'pastExhibitions' => $pastExhibitions,
        ]);
    }

    #[Route('/sergiler/{id}', name: 'app_exhibition_detail')]
    public function detail(Exhibition $exhibition): Response
    {
        return $this->render('exhibition/detail.html.twig', [
            'exhibition' => $exhibition,
        ]);
    }
}
