<?php

namespace App\Service;

use App\ValueObject\PdfDebugComparisonResult;
use Symfony\Component\Filesystem\Filesystem;

final class PdfDebugComparator
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly string $referencesDir,
        private readonly string $actualDir,
    ) {
    }

    /**
     * Converts a binary PDF to PNG images, one per page.
     *
     * @return list<string>
     */
    private function pdfToImages(string $pdfContent, string $prefix, string $outputDir): array
    {
        $imagick = new \Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImageBlob($pdfContent);

        $paths = [];

        foreach ($imagick as $pageIndex => $page) {
            $page->transformImageColorspace(\Imagick::COLORSPACE_SRGB);
            $page->setImageFormat('png');
            $path = sprintf('%s/%s_page%d.png', $outputDir, $prefix, $pageIndex + 1);
            $this->filesystem->dumpFile($path, $page->getImageBlob());
            $paths[] = $path;
        }

        return $paths;
    }

    /**
     * Compares the generated PDF against golden files, page by page.
     *
     * @return list<PdfDebugComparisonResult>
     */
    public function compare(string $pdfName, string $pdfContent): array
    {
        $this->filesystem->mkdir([$this->actualDir]);

        $actualPaths = $this->pdfToImages($pdfContent, 'actual', $this->actualDir);

        $results = [];

        foreach ($actualPaths as $pageIndex => $actualPath) {
            $pageNumber = $pageIndex + 1;
            $referencePath = sprintf('%s/%s_page%d.png', $this->referencesDir, $pdfName, $pageNumber);

            if (!$this->filesystem->exists($referencePath)) {
                $results[] = new PdfDebugComparisonResult(
                    pageNumber: $pageNumber,
                    distortion: null,
                    missingReference: true,
                );
                continue;
            }

            $actual = new \Imagick($actualPath);
            $reference = new \Imagick($referencePath);

            [$diffImagick, $distortion] = $actual->compareImages(
                $reference,
                \Imagick::METRIC_MEANSQUAREERROR,
            );

            $diffPath = sprintf('%s/diff_page%d.png', $this->actualDir, $pageNumber);
            $diffImagick->setImageFormat('png');
            $this->filesystem->dumpFile($diffPath, $diffImagick->getImageBlob());

            $results[] = new PdfDebugComparisonResult(
                pageNumber: $pageNumber,
                distortion: $distortion,
                missingReference: false,
            );
        }

        return $results;
    }

    /**
     * Generates and saves the golden reference files.
     *
     * @return list<string>
     */
    public function generateReferences(string $pdfName, string $pdfContent): array
    {
        $this->filesystem->mkdir($this->referencesDir);

        return $this->pdfToImages($pdfContent, $pdfName, $this->referencesDir);
    }
}
