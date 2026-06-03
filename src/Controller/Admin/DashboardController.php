<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Entity\Assignment;
use App\Entity\Exhibition;
use App\Entity\News;
use App\Entity\Student;
use App\Entity\Submission;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function index(): Response
    {
        $studentCount = $this->entityManager->getRepository(Student::class)->count([]);
        
        $pendingCorrections = $this->entityManager->getRepository(Submission::class)
            ->createQueryBuilder('s')
            ->leftJoin('s.correction', 'c')
            ->where('c.id IS NULL')
            ->getQuery()
            ->getResult();

        $activeExhibitions = $this->entityManager->getRepository(Exhibition::class)
            ->count(['isActive' => true]);

        return $this->render('admin/dashboard.html.twig', [
            'studentCount' => $studentCount,
            'pendingCorrectionsCount' => count($pendingCorrections),
            'pendingCorrections' => $pendingCorrections,
            'activeExhibitions' => $activeExhibitions,
        ]);
    }

    #[Route('/admin/site-ayarlari', name: 'admin_site_settings')]
    public function siteSettings(AdminUrlGenerator $adminUrlGenerator): Response
    {
        $url = $adminUrlGenerator
            ->setController(SiteSettingCrudController::class)
            ->setAction('edit')
            ->setEntityId(1)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hattat Portfolyo');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getName())
            ->setAvatarUrl('uploads/avatars/' . $user->getAvatar())
            ->addMenuItems([
                MenuItem::linkToRoute('Profilim', 'fa fa-user', 'admin_profile')
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Sanat ve İçerik');
        yield MenuItem::linkTo(ArtworkCrudController::class, 'Eserler', 'fas fa-palette');
        yield MenuItem::linkTo(ExhibitionCrudController::class, 'Sergiler', 'fas fa-calendar-alt');
        yield MenuItem::linkTo(NewsCrudController::class, 'Haberler', 'fas fa-newspaper');
        
        yield MenuItem::section('Öğrenci Yönetimi');
        yield MenuItem::linkTo(StudentCrudController::class, 'Öğrenciler', 'fas fa-users');
        yield MenuItem::linkTo(AssignmentCrudController::class, 'Ödevler', 'fas fa-tasks');
        yield MenuItem::linkToRoute('Düzeltmeler', 'fas fa-pen', 'admin_corrections');
        yield MenuItem::linkToRoute('Mesajlar', 'fas fa-envelope', 'admin_messages');
        
        yield MenuItem::section('Sistem');
        yield MenuItem::linkToRoute('Site Ayarları', 'fas fa-cogs', 'admin_site_settings');
        yield MenuItem::linkTo(UserCrudController::class, 'Kullanıcılar', 'fas fa-users-cog');

        yield MenuItem::section('Siteye Dön');
        yield MenuItem::linkToRoute('Ana Sayfa', 'fas fa-globe', 'app_home');
    }
}
