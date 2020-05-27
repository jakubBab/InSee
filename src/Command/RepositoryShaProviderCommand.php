<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\RepositoryCommandFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RepositoryShaProviderCommand extends Command
{
    protected static $defaultName = 'app:repository-sha';

    public const DEFAULT_REPOSITORY = 'github';

    public const OWNER_REPO = 'ownerRepo';

    public const BRANCH = 'branch';

    public const SERVICE = 'service';

    /** @var RepositoryCommandFacade */
    private $repositoryCommandFacade;

    public function __construct(
        RepositoryCommandFacade $repositoryCommandFacade,
        string $name = null)
    {
        $this->repositoryCommandFacade = $repositoryCommandFacade;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument(self::OWNER_REPO, InputArgument::OPTIONAL, 'Repository provider address. Format owner/repo', null);
        $this->addArgument(self::BRANCH, InputArgument::OPTIONAL, 'Repository branch. E.g master', null);
        $this->addOption(self::SERVICE, null, InputOption::VALUE_REQUIRED, 'Repository service', self::DEFAULT_REPOSITORY);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $progressBar = new ProgressBar($output, 3);
        $progressBar->start();
        $progressBar->setProgress(1);

        $this->repositoryCommandFacade->setInput($input);
        $this->repositoryCommandFacade->setOutput($output);

        $validationFailed = $this->repositoryCommandFacade->validate();

        if ($validationFailed) {
            $progressBar->advance();
            $this->repositoryCommandFacade->renderFailedTable();
            $progressBar->finish();
            $this->repositoryCommandFacade->addLineBreak();

            return 1;
        }

        if (false === $this->repositoryCommandFacade->isServiceRequestedAvailable()) {
            $progressBar->advance();
            $messages = sprintf('Service %s is not available.', $input->getOption(self::SERVICE));
            $progressBar->finish();
            $this->repositoryCommandFacade->renderFailedTable([$messages]);
            $this->repositoryCommandFacade->addLineBreak();

            return 1;
        }

        $progressBar->advance();

        if (!$this->repositoryCommandFacade->process()) {
            $this->repositoryCommandFacade->renderFailedTable(['There has been a connection problem with the repository you have provided. Make sure the address is correct and the repository is not password protected']);

            return 1;
        }

        $progressBar->advance();
        $progressBar->finish();

        $this->repositoryCommandFacade->addLineBreak();
        $this->repositoryCommandFacade->renderOutputTable();

        return 0;
    }
}
