<?php

namespace App\Command;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mime\Crypto\SMimeSigner;
use Symfony\Component\Mime\Part\DataPart;

#[AsCommand(
    name: 'app:repro-templated',
    description: 'Reproduce S/MIME signer issue with DataPart and template',
)]
class ReproTemplatedCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Ensure build/cert.pem and build/key.pem exist in your project root
        $cert = 'build/cert.pem';
        $key = 'build/key.pem';

        $email = (new TemplatedEmail())
            ->from('test@example.com')
            ->to('dest@example.com')
            ->htmlTemplate('email.html.twig')
            ->addPart(DataPart::fromPath('pdf/sample.pdf'));

        $signer = new SMimeSigner($cert, $key);
        $signed = $signer->sign($email);

        $output->write($signed->toString());

        return Command::SUCCESS;
    }
}
