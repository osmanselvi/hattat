<?php

namespace App\Controller\Student;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STUDENT')]
class ProfileController extends AbstractController
{
    #[Route('/ogrenci/profil', name: 'app_student_profile')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $student = $user->getStudent();

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $phone = $request->request->get('phone');
            $password = $request->request->get('password');
            $avatar = $request->files->get('avatar');

            if ($name) $user->setName($name);
            if ($phone) $student->setPhone($phone);
            
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
            return $this->redirectToRoute('app_student_profile');
        }

        return $this->render('student/profile/index.html.twig', [
            'user' => $user,
            'student' => $student
        ]);
    }
}
