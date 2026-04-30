<?php

namespace App\Controller;

use App\Service\PdfDebugComparator;
use Sensiolabs\GotenbergBundle\GotenbergPdfInterface;
use Sensiolabs\GotenbergBundle\Processor\FileProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pdf/debug')]
final class PdfDebugController extends AbstractController
{
    public function __construct(
        private readonly PdfDebugComparator $comparator,
        private readonly Filesystem $filesystem,
        private readonly string $pdfStorage,
        private readonly string $publicDebugDir,
        private readonly string $referencesDir,
    ) {}

    #[Route('', name: 'app_pdf_debug')]
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

    #[Route('/image/{type}/{page}', name: 'app_pdf_debug_image', requirements: ['type' => 'actual|reference|diff', 'page' => '\d+'])]
    public function image(string $type, int $page): BinaryFileResponse
    {
        $path = match($type) {
            'actual'    => sprintf('%s/actual_page%d.png', $this->publicDebugDir, $page),
            'diff'      => sprintf('%s/diff_page%d.png', $this->publicDebugDir, $page),
            'reference' => sprintf('%s/reference_page%d.png', $this->referencesDir, $page),
        };

        if (!$this->filesystem->exists($path)) {
            throw new NotFoundHttpException(sprintf('Image "%s" page %d not found.', $type, $page));
        }

        return new BinaryFileResponse($path);
    }
}
