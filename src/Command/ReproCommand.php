<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mime\Crypto\SMimeSigner;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;

#[AsCommand(
    name: 'app:repro',
    description: 'Reproduce S/MIME signer issue with DataPart',
)]
class ReproCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Ensure cert.pem and key.pem exist in your project root
        $cert = 'cert.pem';
        $key = 'key.pem';

        $email = (new Email())
            ->from('test@example.com')
            ->to('dest@example.com')
            ->html('<h1>Hello</h1>')
            ->addPart(new DataPart('binary content', 'file.pdf'));

        $signer = new SMimeSigner($cert, $key);
        $signed = $signer->sign($email);

        $output->write($signed->toString());

        return Command::SUCCESS;
    }
}
