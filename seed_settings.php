<?php
require __DIR__.'/vendor/autoload.php';
$kernel = new App\Kernel('dev', true);
$kernel->boot();

$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

$siteSetting = new \App\Entity\SiteSetting();
$siteSetting->setHeroTitle('Geleneksel Sanatın Modern Yüzü');
$siteSetting->setHeroSubtitle('Klasik hat sanatının zarafetini modern bir anlayışla birleştiriyoruz. Özel eserler, eğitimler ve daha fazlası.');
$siteSetting->setAboutText('Uzun yıllardır hat sanatıyla ilgileniyorum. Birçok ulusal ve uluslararası sergide yer aldım. Klasik hat sanatının zarafetini modern bir anlayışla birleştiriyorum.');
$siteSetting->setContactAddress('İstanbul, Türkiye');
$siteSetting->setContactEmail('info@hattatportfolyo.com');
$siteSetting->setContactPhone('+90 (555) 123 45 67');
$siteSetting->setSocialInstagram('#');
$siteSetting->setSocialTwitter('#');

$em->persist($siteSetting);
$em->flush();

echo "Site settings seeded!\n";
