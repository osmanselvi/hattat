<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ProfileController extends AbstractController
{
    #[Route('/admin/profil', name: 'admin_profile')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $password = $request->request->get('password');
            $avatar = $request->files->get('avatar');

            if ($name) $user->setName($name);
            
            if ($password) {
                $user->setPassword($passwordHasher->hashPassword($user, $password));
            }

            if ($avatar) {
                $filename = md5(uniqid()) . '.' . $avatar->guessExtension();
                $avatar->move($this->getParameter('kernel.project_dir') . '/public/uploads/avatars', $filename);
                $user->setAvatar($filename);
            }

            $em->flush();
            $this->addFlash('success', 'Profiliniz başarıyla güncellendi.');
            return $this->redirectToRoute('admin_profile');
        }

        return $this->render('admin/profile/index.html.twig', [
            'user' => $user
        ]);
    }
}
