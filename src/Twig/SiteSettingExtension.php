<?php

namespace App\Twig;

use App\Repository\SiteSettingRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SiteSettingExtension extends AbstractExtension
{
    public function __construct(private SiteSettingRepository $repository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('site_settings', [$this, 'getSettings']),
        ];
    }

    public function getSettings()
    {
        // Return the first and only SiteSetting record (ID 1)
        return $this->repository->find(1);
    }
}
