<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class RepositoryConstraint extends Constraint
{
    public $message = 'The repository "{{ string }}" has to conform to the format "owner/repository". Allowed: alphanumeric';
}
