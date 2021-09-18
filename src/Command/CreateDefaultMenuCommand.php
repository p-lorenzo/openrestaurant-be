<?php

namespace App\Command;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateDefaultMenuCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected static $defaultName = 'app:menu:create';

    protected function configure()
    {
        $this
            ->setDescription('Create the default active menu')
            ->addOption('title', null, InputOption::VALUE_REQUIRED, 'Titolo menu (required)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io    = new SymfonyStyle($input, $output);
        $title = $input->getOption('title');
        if (empty($title)) {
            $io->error("Devi scegliere un titolo per il menu");

            return 1;
        }

        $menu = new Menu();
        $menu->setActive(true)
            ->setTitle($title);

        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return 0;
    }
}
