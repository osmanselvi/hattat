<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class PageController extends AbstractController
{
    #[Route('/hakkinda', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig');
    }

    #[Route('/iletisim', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Adınız Soyadınız',
                'constraints' => [new NotBlank(['message' => 'Lütfen adınızı girin.'])]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-posta Adresiniz',
                'constraints' => [
                    new NotBlank(['message' => 'Lütfen e-posta adresinizi girin.']),
                    new Email(['message' => 'Lütfen geçerli bir e-posta adresi girin.'])
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Konu',
                'constraints' => [new NotBlank(['message' => 'Lütfen bir konu girin.'])]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Mesajınız',
                'attr' => ['rows' => 5],
                'constraints' => [new NotBlank(['message' => 'Lütfen mesajınızı girin.'])]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Gönder',
                'attr' => ['class' => 'btn btn-primary px-4']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mesaj gönderme işlemi burada yapılabilir (örn. Mailer)
            $this->addFlash('success', 'Mesajınız başarıyla alındı. En kısa sürede size dönüş yapacağız.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('page/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
