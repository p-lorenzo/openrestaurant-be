<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AddUserCommand extends Command
{
    protected static $defaultName = 'app:user:create';
    private EntityManagerInterface $entityManager;
    private PasswordHasherFactoryInterface $passwordHasherFactory;

    public function __construct(EntityManagerInterface $entityManager, PasswordHasherFactoryInterface $passwordHasherFactory)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasherFactory = $passwordHasherFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create an admin user from command line')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'E-mail (required)')
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'Plain password')
            ->addOption('admin', null, InputOption::VALUE_NONE, 'Add admin access');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io    = new SymfonyStyle($input, $output);
        $email = $input->getOption('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error("Invalid email");

            return 1;
        }

        $plainPassword = $input->getOption('password');
        if (empty($plainPassword)) {
            $io->error("You must set a password");

            return 1;
        }


        $user = new User();
        $passwordHasher = $this->passwordHasherFactory->getPasswordHasher($user);
        $password = $passwordHasher->hash($plainPassword);
        $user->setEmail($email)
            ->setPassword($password);

        if ($input->getOption('admin')) {
            $user->giveAdminPrivileges();
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return 0;
    }
}
