<?php

namespace App\Controller\Admin;

use App\Entity\Assignment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AssignmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Assignment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Ödev Başlığı'),
            AssociationField::new('student', 'Öğrenci'),
            DateField::new('dueDate', 'Son Teslim Tarihi'),
            ChoiceField::new('status', 'Durum')->setChoices([
                'Beklemede' => 'beklemede',
                'Teslim Edildi' => 'teslim edildi',
                'Düzeltildi' => 'düzeltildi',
            ]),
            TextareaField::new('description', 'Açıklama')->hideOnIndex(),
        ];
    }
}
