<?php

namespace App\Controller\Admin;

use App\Entity\Exhibition;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ExhibitionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exhibition::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Başlık'),
            TextField::new('location', 'Konum'),
            DateField::new('startDate', 'Başlangıç Tarihi'),
            DateField::new('endDate', 'Bitiş Tarihi'),
            TextareaField::new('description', 'Açıklama')->hideOnIndex(),
            ImageField::new('coverImage', 'Kapak Görseli')
                ->setBasePath('uploads/exhibitions')
                ->setUploadDir('public/uploads/exhibitions')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            BooleanField::new('isActive', 'Aktif mi?'),
        ];
    }
}
