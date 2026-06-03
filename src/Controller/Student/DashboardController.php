<?php

namespace App\Controller\Student;

use App\Entity\Assignment;
use App\Entity\Message;
use App\Entity\Submission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STUDENT')]
class DashboardController extends AbstractController
{
    #[Route('/ogrenci/panel', name: 'app_student_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        $student = $this->getUser()->getStudent();
        if (!$student) {
            throw $this->createAccessDeniedException('Student profile not found.');
        }

        $assignments = $em->getRepository(Assignment::class)->findBy(['student' => $student], ['dueDate' => 'DESC']);
        
        $pendingCount = 0;
        $submittedCount = 0;
        $correctedCount = 0;
        
        foreach ($assignments as $a) {
            if ($a->getStatus() === 'beklemede') $pendingCount++;
            if ($a->getStatus() === 'teslim edildi') $submittedCount++;
            if ($a->getStatus() === 'düzeltildi') $correctedCount++;
        }

        $unreadMessages = $em->getRepository(Message::class)->count([
            'student' => $student,
            'senderRole' => 'ROLE_ADMIN',
            'isRead' => false
        ]);

        return $this->render('student/dashboard.html.twig', [
            'assignments' => array_slice($assignments, 0, 5),
            'pendingCount' => $pendingCount,
            'submittedCount' => $submittedCount,
            'correctedCount' => $correctedCount,
            'unreadMessages' => $unreadMessages,
        ]);
    }
}
