<?php

namespace App\Controller;

use App\Service\PdfDebugComparator;
use Sensiolabs\GotenbergBundle\GotenbergPdfInterface;
use Sensiolabs\GotenbergBundle\Processor\FileProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PdfDebugController extends AbstractController
{
    public function __construct(
        private readonly PdfDebugComparator $comparator,
        private readonly Filesystem $filesystem,
        private readonly string $pdfStorage,
    ) {}

    #[Route('/pdf/debug', name: 'app_pdf_debug')]
    public function debug(GotenbergPdfInterface $gotenberg): Response
    {
        $pdfName = 'debug';

        $gotenberg
            ->html()
            ->content('pdf/content.html.twig')
            ->footer('pdf/footer.html.twig')
            ->fileName($pdfName)
            ->processor(new FileProcessor($this->filesystem, $this->pdfStorage))
            ->generate()
            ->stream();

        $pdfContent = file_get_contents($this->pdfStorage . '/' . $pdfName . '.pdf');

        $results = $this->comparator->compare($pdfName, $pdfContent);

        return $this->render('pdf_debug/index.html.twig', [
            'results' => $results,
        ]);
    }
}
