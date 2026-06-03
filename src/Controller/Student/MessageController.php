<?php

namespace App\Controller\Student;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STUDENT')]
class MessageController extends AbstractController
{
    #[Route('/ogrenci/mesajlar', name: 'app_student_messages')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $student = $this->getUser()->getStudent();

        if ($request->isMethod('POST')) {
            $content = $request->request->get('content');
            if ($content) {
                $message = new Message();
                $message->setStudent($student);
                $message->setSenderRole('ROLE_STUDENT');
                $message->setContent($content);
                $em->persist($message);
                $em->flush();
            }
            return $this->redirectToRoute('app_student_messages');
        }

        $messages = $em->getRepository(Message::class)->findBy(
            ['student' => $student],
            ['sentAt' => 'ASC']
        );

        // Mark admin messages as read
        $hasUnread = false;
        foreach ($messages as $msg) {
            if ($msg->getSenderRole() === 'ROLE_ADMIN' && !$msg->isRead()) {
                $msg->setIsRead(true);
                $hasUnread = true;
            }
        }
        if ($hasUnread) {
            $em->flush();
        }

        return $this->render('student/message/index.html.twig', [
            'messages' => $messages,
        ]);
    }
}
