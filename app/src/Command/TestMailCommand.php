<?php

namespace App\Command;

use App\Service\SendMailService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-mail',
    description: 'Test l\'envoi de mail avec signature DKIM',
)]
class TestMailCommand extends Command
{
    private SendMailService $mailService;

    public function __construct(SendMailService $mailService)
    {
        $this->mailService = $mailService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Test d\'envoi de mail avec DKIM');

        $context = [
            'mail' => 'test@example.com',
            'name' => 'Test User',
            'phone' => '+33 6 12 34 56 78',
            'subject' => 'Test depuis la commande Symfony',
            'message' => 'Ceci est un test d\'envoi de mail avec signature DKIM.'
        ];

        try {
            $io->section('Envoi du mail en cours...');

            $this->mailService->send(
                'test@example.com',
                'p.gerin@usygec.fr',
                'Test mail - ' . date('Y-m-d H:i:s'),
                'contact_template',
                $context
            );

            $io->success('Mail envoyé avec succès !');
            $io->note('Consultez les logs dans var/log/dev.log pour plus de détails');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $io->error('Erreur lors de l\'envoi du mail');
            $io->writeln('<error>Message : ' . $e->getMessage() . '</error>');
            $io->writeln('<comment>Fichier : ' . $e->getFile() . ':' . $e->getLine() . '</comment>');

            if ($output->isVerbose()) {
                $io->section('Trace complète :');
                $io->writeln($e->getTraceAsString());
            }

            return Command::FAILURE;
        }
    }
}
