<?php

declare(strict_types=1);

namespace App\Command;

use App\Controller\Services\RepositoryFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    /** @var RepositoryFactory */
    private $repositoryFactory;

    private const DEFAULT_REPOSITORY = 'github';

    public function __construct(RepositoryFactory $repositoryFactory, string $name = null)
    {
        $this->repositoryFactory = $repositoryFactory;
        parent::__construct($name);
    }

    protected static $defaultName = 'app:create-user';

    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'GitHub address. Format owner/repo');
        $this->addOption('service', null, InputOption::VALUE_REQUIRED, 'Repository service', 'github');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->repositoryFactory->isAvailable('github')) {
            $repository = $this->repositoryFactory->getRepositoryByName('github');
            $repository->getCommit();
            $sha = $repository->getSha();
            dump($sha);
        }

        die;

        return 0;
    }
}
