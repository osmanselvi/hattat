<?php

namespace App\Controller\Admin;

use App\Entity\SiteSetting;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SiteSettingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SiteSetting::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Site Ayarlarını Düzenle')
            ->setPageTitle('detail', 'Site Ayarları')
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        
        yield TextField::new('heroTitle', 'Ana Sayfa Başlığı');
        yield TextareaField::new('heroSubtitle', 'Ana Sayfa Alt Başlığı')->hideOnIndex();
        
        yield TextareaField::new('aboutText', 'Hakkında Yazısı')->hideOnIndex();
        
        yield TextField::new('contactAddress', 'Adres Bilgisi');
        yield TextField::new('contactEmail', 'E-posta');
        yield TextField::new('contactPhone', 'Telefon');
        
        yield UrlField::new('socialInstagram', 'Instagram Linki')->hideOnIndex();
        yield UrlField::new('socialTwitter', 'Twitter Linki')->hideOnIndex();
    }
}
