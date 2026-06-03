<?php

namespace App\Controller\Student;

use App\Entity\Assignment;
use App\Entity\Submission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STUDENT')]
class AssignmentController extends AbstractController
{
    #[Route('/ogrenci/odevler', name: 'app_student_assignments')]
    public function index(EntityManagerInterface $em): Response
    {
        $assignments = $em->getRepository(Assignment::class)->findBy(
            ['student' => $this->getUser()->getStudent()],
            ['dueDate' => 'DESC']
        );
        return $this->render('student/assignment/index.html.twig', [
            'assignments' => $assignments,
        ]);
    }

    #[Route('/ogrenci/odev/{id}', name: 'app_student_assignment_detail')]
    public function detail(Assignment $assignment): Response
    {
        if ($assignment->getStudent() !== $this->getUser()->getStudent()) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('student/assignment/detail.html.twig', [
            'assignment' => $assignment,
        ]);
    }

    #[Route('/ogrenci/odev/{id}/teslim', name: 'app_student_assignment_submit')]
    public function submit(Assignment $assignment, Request $request, EntityManagerInterface $em): Response
    {
        if ($assignment->getStudent() !== $this->getUser()->getStudent()) {
            throw $this->createAccessDeniedException();
        }

        if ($request->isMethod('POST')) {
            $file = $request->files->get('artworkImage');
            $note = $request->request->get('studentNote');

            if ($file) {
                // Find existing submission or create new
                $submission = $em->getRepository(Submission::class)->findOneBy(['assignment' => $assignment]) ?? new Submission();
                $submission->setAssignment($assignment);
                $submission->setStudent($this->getUser()->getStudent());
                $submission->setStudentNote($note);
                $submission->setSubmittedAt(new \DateTimeImmutable());
                
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('kernel.project_dir') . '/public/uploads/submissions', $filename);
                $submission->setImagePath($filename);

                $assignment->setStatus('teslim edildi');

                $em->persist($submission);
                $em->flush();

                $this->addFlash('success', 'Ödeviniz başarıyla teslim edildi.');
                return $this->redirectToRoute('app_student_assignment_detail', ['id' => $assignment->getId()]);
            } else {
                $this->addFlash('danger', 'Lütfen bir görsel yükleyin.');
            }
        }

        return $this->render('student/assignment/submit.html.twig', [
            'assignment' => $assignment,
        ]);
    }

    #[Route('/ogrenci/duzeltmeler', name: 'app_student_corrections')]
    public function corrections(EntityManagerInterface $em): Response
    {
        $submissions = $em->getRepository(Submission::class)->findBy(
            ['student' => $this->getUser()->getStudent()],
            ['submittedAt' => 'DESC']
        );
        return $this->render('student/assignment/corrections.html.twig', [
            'submissions' => $submissions,
        ]);
    }
}
