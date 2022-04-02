<?php


namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputOption;

class UserListCommand extends Command
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
            ->setName('app:user:list')
            ->setDescription('foo bar')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL)
        ;
    }


    public function execute(InputInterface $input, OutputInterface $output): int 
    {
        $userRepo = $this->em->getRepository(User::class);
        
        $userName = $input->getOption('name');

        $options = [];
        if ($userName !== null) {
            $options['name'] = $userName;
        }

        /**
         * @var User[]
         */
        $users = $userRepo->findBy($options);

        $table = new Table($output);
        $table->setHeaders(['id', 'name', 'birthDate']);

        foreach($users as $user) {
            $table->addRow([$user->getId(), $user->getName(), $user->getBirthDate()->format('Y-m-d')]);
        }

        $table->render();

        return 0;
    }
}