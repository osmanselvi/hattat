<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class ArtworkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artwork::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Başlık');
        
        yield ChoiceField::new('category', 'Kategori')->setChoices([
            'Celî Sülüs' => 'Celî Sülüs',
            'Nesih' => 'Nesih',
            "Ta'lîk" => "Ta'lîk",
            "Rık'a" => "Rık'a",
            'Dîvânî' => 'Dîvânî',
            'Diğer' => 'Diğer',
        ]);
        
        yield TextareaField::new('description', 'Açıklama')->hideOnIndex();
        
        yield ImageField::new('imagePath', 'Görsel')
            ->setBasePath('uploads/artworks')
            ->setUploadDir('public/uploads/artworks')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false); // Make false so it doesn't break edit
            
        yield BooleanField::new('isFeatured', 'Öne Çıkan');
        yield BooleanField::new('isHeroBackground', 'Ana Sayfa Arka Planı (Hero) Yap');
        yield DateTimeField::new('createdAt', 'Eklenme Tarihi')->hideOnForm();
    }
}
