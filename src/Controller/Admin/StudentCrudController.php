<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StudentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user', 'Kullanıcı Hesabı'),
            TextField::new('phone', 'Telefon No'),
            ChoiceField::new('level', 'Seviye')->setChoices([
                'Başlangıç' => 'başlangıç',
                'Orta' => 'orta',
                'İleri' => 'ileri',
            ]),
            DateField::new('enrollmentDate', 'Kayıt Tarihi'),
            TextareaField::new('notes', 'Öğretmen Notları')->hideOnIndex(),
        ];
    }
}
