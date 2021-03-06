<?php

declare(strict_types=1);

namespace App\Service;

use App\Command\RepositoryShaProviderCommand;
use App\Util\ConsoleOutputTable;
use App\Util\ErrorConsoleOutputTable;
use App\Util\Repository\Contract\RepositoryInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RepositoryCommandFacade
{
    /** @var OutputInterface */
    private $output;

    /** @var RepositoryFactory */
    private $repositoryFactory;

    /** @var RequestValidatorService */
    private $requestValidatorService;

    /** @var InputInterface */
    private $input;

    /** @var RepositoryInterface */
    private $repository;

    public function __construct(
        RepositoryFactory $repositoryFactory,
        RequestValidatorService $requestValidatorService
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->requestValidatorService = $requestValidatorService;
    }

    public function validate(): bool
    {
        $requestValues = $this->getArgumentsAndOptions();
        $this->requestValidatorService->validate($requestValues);

        return !empty($this->requestValidatorService->getErrorMessages());
    }

    public function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    private function getArgumentsAndOptions(): array
    {
        $arguments = $this->input->getArguments([RepositoryShaProviderCommand::OWNER_REPO, RepositoryShaProviderCommand::BRANCH]);
        unset($arguments['command']);
        $arguments[RepositoryShaProviderCommand::SERVICE] = $this->input->getOption('service');

        return $arguments;
    }

    public function renderFailedTable($errors = []): void
    {
        $this->addLineBreak();
        $errorMessages = empty($errors) ? $this->requestValidatorService->getErrorMessages() : $errors;
        $consoleOutputTable = new ErrorConsoleOutputTable($this->output);
        $consoleOutputTable->setHeaders([]);
        $consoleOutputTable->setTableData(
            $errorMessages
        );

        $consoleOutputTable->render();
    }

    public function process(): bool
    {
        $values = $this->getArgumentsAndOptions();
        $this->repositoryFactory->setOwner($values[RepositoryShaProviderCommand::OWNER_REPO]);
        $this->repositoryFactory->setBranchName($values[RepositoryShaProviderCommand::BRANCH]);
        $this->repository = $this->repositoryFactory->getRepositoryByName($values[RepositoryShaProviderCommand::SERVICE]);

        return !empty($this->repository->getCommit());
    }

    public function isServiceRequestedAvailable(): bool
    {
        $values = $this->getArgumentsAndOptions();

        return $this->repositoryFactory->isAvailable($values[RepositoryShaProviderCommand::SERVICE]);
    }

    public function renderOutputTable(): void
    {
        $values = $this->getArgumentsAndOptions();

        $consoleOutputTable = new ConsoleOutputTable($this->output);
        $consoleOutputTable->setHeaders([]);
        $consoleOutputTable->setTableData(
            $values['ownerRepo'],
            $values['branch'],
            $values['service'],
            $this->repository->getSha()
        );

        $consoleOutputTable->render();
    }

    public function addLineBreak(): void
    {
        $this->output->writeln([
            '',
            '',
            '',
        ]);
    }
}
