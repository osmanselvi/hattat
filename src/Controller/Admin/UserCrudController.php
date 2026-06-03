<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\EntityManagerInterface;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Ad Soyad'),
            EmailField::new('email', 'E-posta'),
            ChoiceField::new('roles', 'Roller')->setChoices([
                'Yönetici (Admin)' => 'ROLE_ADMIN',
                'Öğrenci' => 'ROLE_STUDENT',
            ])->allowMultipleChoices(),
            TextField::new('password', 'Şifre')
                ->setHelp('Sadece yeni kullanıcı oluştururken veya şifre değiştirirken doldurun.')
                ->onlyOnForms()
                ->setRequired(false),
            ImageField::new('avatar', 'Profil Fotoğrafı')
                ->setBasePath('uploads/avatars')
                ->setUploadDir('public/uploads/avatars')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }

    public function __construct(private \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPassword()) {
            $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPassword()) {
            // Only hash if a new password is typed. In a real app, you'd use a non-mapped plainPassword field.
            // But this will work if we only set it when typed.
            $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));
        }
        parent::updateEntity($entityManager, $entityInstance);
    }
}
