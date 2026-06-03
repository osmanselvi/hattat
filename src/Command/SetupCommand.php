<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Student;
use App\Entity\SiteSetting;

#[AsCommand(
    name: 'app:setup',
    description: 'Initializes the database with default admin and student users.',
)]
class SetupCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Check if admin exists
        $admin = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'admin@hattat.com']);
        if (!$admin) {
            $admin = new User();
            $admin->setName('Sistem Yöneticisi');
            $admin->setEmail('admin@hattat.com');
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
            $this->entityManager->persist($admin);
            $io->success('Admin user created (admin@hattat.com / admin123)');
        }

        // Check if student exists
        $studentUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'ogrenci@hattat.com']);
        if (!$studentUser) {
            $studentUser = new User();
            $studentUser->setName('Test Öğrenci');
            $studentUser->setEmail('ogrenci@hattat.com');
            $studentUser->setRoles(['ROLE_STUDENT']);
            $studentUser->setPassword($this->passwordHasher->hashPassword($studentUser, 'ogrenci123'));

            $student = new Student();
            $student->setUser($studentUser);
            $student->setPhone('5551234567');
            $student->setLevel('başlangıç');
            $student->setEnrollmentDate(new \DateTime());
            $student->setNotes('Test öğrencisi otomatik oluşturuldu.');

            $this->entityManager->persist($studentUser);
            $this->entityManager->persist($student);
            $io->success('Student user created (ogrenci@hattat.com / ogrenci123)');
        }

        // Check if site settings exist
        $settings = $this->entityManager->getRepository(SiteSetting::class)->findAll();
        if (empty($settings)) {
            $siteSetting = new SiteSetting();
            $siteSetting->setHeroTitle('Geleneksel Sanatın Modern Yüzü');
            $siteSetting->setHeroSubtitle('Klasik hat sanatının zarafetini modern bir anlayışla birleştiriyoruz. Özel eserler, eğitimler ve daha fazlası.');
            $siteSetting->setAboutText('Uzun yıllardır hat sanatıyla ilgileniyorum. Birçok ulusal ve uluslararası sergide yer aldım. Klasik hat sanatının zarafetini modern bir anlayışla birleştiriyorum.');
            $siteSetting->setContactAddress('İstanbul, Türkiye');
            $siteSetting->setContactEmail('info@hattatportfolyo.com');
            $siteSetting->setContactPhone('+90 (555) 123 45 67');
            $siteSetting->setSocialInstagram('#');
            $siteSetting->setSocialTwitter('#');
            $this->entityManager->persist($siteSetting);
            $io->success('Default site settings created.');
        }

        $this->entityManager->flush();

        $io->success('Setup completed successfully.');

        return Command::SUCCESS;
    }
}
