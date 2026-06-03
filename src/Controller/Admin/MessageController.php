<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    #[Route('/admin/mesajlar', name: 'admin_messages')]
    public function index(EntityManagerInterface $em): Response
    {
        // Get all students to show in the list
        $students = $em->getRepository(Student::class)->findAll();
        
        return $this->render('admin/message/index.html.twig', [
            'students' => $students
        ]);
    }

    #[Route('/admin/mesajlar/{id}', name: 'admin_message_chat')]
    public function chat(Student $student, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $content = $request->request->get('content');
            if ($content) {
                $message = new Message();
                $message->setStudent($student);
                $message->setSenderRole('ROLE_ADMIN');
                $message->setContent($content);
                $em->persist($message);
                $em->flush();
            }
            return $this->redirectToRoute('admin_message_chat', ['id' => $student->getId()]);
        }

        $messages = $em->getRepository(Message::class)->findBy(
            ['student' => $student],
            ['sentAt' => 'ASC']
        );

        // Mark student messages as read
        $hasUnread = false;
        foreach ($messages as $msg) {
            if ($msg->getSenderRole() === 'ROLE_STUDENT' && !$msg->isRead()) {
                $msg->setIsRead(true);
                $hasUnread = true;
            }
        }
        if ($hasUnread) {
            $em->flush();
        }

        return $this->render('admin/message/chat.html.twig', [
            'student' => $student,
            'messages' => $messages
        ]);
    }
}
