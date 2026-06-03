<?php

namespace App\Controller;

use App\Entity\Artwork;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    #[Route('/galeri', name: 'app_gallery')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $category = $request->query->get('kategori');
        
        $qb = $em->getRepository(Artwork::class)->createQueryBuilder('a');
        
        if ($category) {
            $qb->where('a.category = :category')
               ->setParameter('category', $category);
        }
        
        $qb->orderBy('a.createdAt', 'DESC');
        
        // Paginator logic could be added here, but for simplicity we fetch all matching
        $artworks = $qb->getQuery()->getResult();

        return $this->render('gallery/index.html.twig', [
            'artworks' => $artworks,
            'currentCategory' => $category,
        ]);
    }
}
