<?php

namespace App\Controller;

use Sensiolabs\GotenbergBundle\GotenbergPdfInterface;
use Sensiolabs\GotenbergBundle\Processor\FileProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function pdf(GotenbergPdfInterface $gotenberg): Response
    {
        return $gotenberg
            ->html()
            ->content('pdf/font.html.twig')
            ->generate()
            ->stream();
    }

    #[Route('/embed', name: 'app_embed')]
    public function embed(GotenbergPdfInterface $gotenberg): Response
    {
        return $gotenberg
            ->html()
            ->content('pdf/font.html.twig')
            ->embedFiles('file/embeds.xml')
            ->landscape()
            ->generate()
            ->stream();
    }

    #[Route(path: '/processor', name: 'my_pdf')]
    public function processor(
        GotenbergPdfInterface $gotenbergPdf,
        Filesystem $filesystem,
        #[Autowire('%kernel.project_dir%/var/pdf')]
        string $pdfStorage,
    ): Response {
        return $gotenbergPdf->html()
            ->content('pdf/font.html.twig')
            ->fileName('my_pdf')
            ->processor(
                new FileProcessor(
                    $filesystem,
                    $pdfStorage,
                )
            )
            ->generate()
            ->stream();
    }
}

