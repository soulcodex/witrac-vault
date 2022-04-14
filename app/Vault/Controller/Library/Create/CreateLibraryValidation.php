<?php

namespace App\Vault\Controller\Library\Create;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Witrac\Shared\Infrastructure\Symfony\Validation\ValidationFailedException;

final class CreateLibraryValidation
{
    /**
     * @throws ValidationFailedException
     */
    public static function validated(Request $request): void
    {
        $constraints = new Assert\Collection([
            'name' => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 255])],
        ]);

        $errors = Validation::createValidator()->validate($request->request->all(), $constraints);

        if ($errors->count()) {
            throw new ValidationFailedException($errors);
        }
    }
}
