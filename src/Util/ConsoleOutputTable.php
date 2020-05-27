<?php

declare(strict_types=1);

namespace App\Util;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputTable extends Table
{
    public function __construct(OutputInterface $output)
    {
        parent::__construct($output);
    }

    private $header = [
        'owner/repo', 'branch', 'service', 'sha',
    ];

    public function setTableData(string $owner, string $branch, string $service, string $sha)
    {
        $this->setRows([
            [$owner, $branch, $service, $sha],
        ]);
    }

    public function setHeaders(array $headers)
    {
        $headers = !empty($headers) ? $headers : $this->header;

        return parent::setHeaders($this->header);
    }
}
