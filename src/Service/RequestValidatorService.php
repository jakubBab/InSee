<?php

declare(strict_types=1);

namespace App\Service;

use App\Util\Validation\RepositoryCommandValidation;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class RequestValidatorService
{
    private $constraints;

    /** @var array */
    private $dataToValidate;

    private $errors = [];

    private $validator;

    public function __construct(RepositoryCommandValidation $repositoryCommandValidation)
    {
        $this->constraints = $repositoryCommandValidation->getConstraints();
        $this->validator = Validation::createValidator();
    }

    public function validate(array $dataToValidate): void
    {
        $this->errors = $this->validator->validate($dataToValidate, $this->constraints);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): Object
    {
        return $this->errors;
    }

    public function getErrorMessages(): array
    {
        $errorMessages = [];
        if (!$this->hasErrors()) {
            return $errorMessages;
        }
        /** @var ConstraintViolation $error */
        foreach ($this->getErrors() as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return $errorMessages;
    }
}
