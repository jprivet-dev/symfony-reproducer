<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mime\Crypto\SMimeSigner;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:valid',
    description: 'A valid S/MIME signature example (text only)',
)]
class ValidCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cert = 'build/cert.pem';
        $key = 'build/key.pem';

        // Simple text email, no attachments
        $email = (new Email())
            ->from('test@example.com')
            ->to('dest@example.com')
            ->subject('Valid Signature Test')
            ->text('This is a simple text body.');

        $signer = new SMimeSigner($cert, $key);
        $signed = $signer->sign($email);

        $output->write($signed->toString());

        return Command::SUCCESS;
    }
}
