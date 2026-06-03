<?php

namespace App\Controller\Admin;

use App\Entity\Correction;
use App\Entity\Submission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CorrectionController extends AbstractController
{
    #[Route('/admin/duzeltmeler', name: 'admin_corrections')]
    public function index(EntityManagerInterface $em): Response
    {
        $submissions = $em->getRepository(Submission::class)->findAll();
        
        return $this->render('admin/correction/index.html.twig', [
            'submissions' => $submissions
        ]);
    }

    #[Route('/admin/duzeltme/{id}', name: 'admin_correction_edit')]
    public function edit(Submission $submission, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $note = $request->request->get('teacherNote');
            $file = $request->files->get('correctedImage');

            $correction = $submission->getCorrection() ?? new Correction();
            $correction->setSubmission($submission);
            $correction->setTeacherNote($note);

            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move($this->getParameter('kernel.project_dir') . '/public/uploads/corrections', $filename);
                $correction->setCorrectedImagePath($filename);
            }

            // Update assignment status
            $submission->getAssignment()->setStatus('düzeltildi');

            $em->persist($correction);
            $em->flush();

            $this->addFlash('success', 'Düzeltme başarıyla kaydedildi.');
            return $this->redirectToRoute('admin_corrections');
        }

        return $this->render('admin/correction/edit.html.twig', [
            'submission' => $submission
        ]);
    }
}
