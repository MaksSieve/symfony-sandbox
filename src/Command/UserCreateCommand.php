<?php


namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DateTime;

class UserCreateCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    public function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('foo bar')
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument('birthDate', InputArgument::OPTIONAL)
        ;
    }


    public function execute(InputInterface $input, OutputInterface $output): int 
    {
        $user = new User();
        $user
            ->setName($input->getArgument('name'))
            ->setBirthDate(new DateTime($input->getArgument('birthDate')))
        ;

        $this->em->persist($user);
        $this->em->flush();

        return 0;
    }
}