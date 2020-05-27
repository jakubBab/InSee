<?php

declare(strict_types=1);

namespace App\Util\Validation;

use App\Validator\Constraints\RepositoryConstraint;
use Symfony\Component\Validator\Constraints as Assert;

class RepositoryCommandValidation
{
    public function getConstraints()
    {
        return
            new Assert\Collection([
                'ownerRepo' => [
                    new Assert\Type('string'),
                    new RepositoryConstraint(),
                    new Assert\NotNull(['message' => 'owner/repo value missing']),
                ],
                'branch' => [
                    new Assert\Type('string'),
                    new Assert\NotNull(['message' => 'Branch value missing']), ],
                'service' => new Assert\Optional([
                    new Assert\Type('string'),
                ]),
            ]);
    }
}
