<?php

namespace App\Command;

use App\Service\PdfDebugComparator;
use Sensiolabs\GotenbergBundle\GotenbergPdfInterface;
use Sensiolabs\GotenbergBundle\Processor\FileProcessor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:pdf:generate',
    description: 'Generates PDF golden reference files for visual snapshot testing',
)]
final class PdfDebugGenerateReferencesCommand extends Command
{
    public function __construct(
        private readonly GotenbergPdfInterface $gotenberg,
        private readonly PdfDebugComparator $comparator,
        private readonly Filesystem $filesystem,
        private readonly string $pdfStorage,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generating PDF reference files');

        $pdfName = 'reference';

        $this->gotenberg
            ->html()
            ->content('pdf/content.html.twig')
            ->footer('pdf/footer.html.twig')
            ->fileName($pdfName)
            ->processor(
                new FileProcessor(
                    $this->filesystem,
                    $this->pdfStorage
                )
            )
            ->generate()
            ->stream();

        $pdfContent = file_get_contents($this->pdfStorage.'/'.$pdfName.'.pdf');

        $paths = $this->comparator->generateReferences($pdfName, $pdfContent);

        $io->success(sprintf('%d reference file(s) generated:', count($paths)));
        $io->listing($paths);

        return Command::SUCCESS;
    }
}
