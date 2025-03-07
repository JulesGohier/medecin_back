<?php

namespace App\Command;

use App\Entity\RendezVous;
use App\Enum\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:update-past-appointments',
    description: 'Met à jour les rendez-vous passés en état "passé".',
)]
class UpdatePastAppointmentsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $now = new \DateTime();

        // Récupérer les rendez-vous passés qui ne sont pas annulés
        $rendezVousRepository = $this->entityManager->getRepository(RendezVous::class);
        $rendezVousPasses = $rendezVousRepository->createQueryBuilder('r')
            ->where('r.date < :now')
            ->andWhere('r.state = :reserve')
            ->setParameter('now', $now)
            ->setParameter('reserve', State::RESERVE)
            ->getQuery()
            ->getResult();

        foreach ($rendezVousPasses as $rdv) {
            $rdv->setState(State::PASSE);
        }

        $this->entityManager->flush();

        $output->writeln(count($rendezVousPasses) . ' rendez-vous mis à jour.');

        return Command::SUCCESS;
    }
}
