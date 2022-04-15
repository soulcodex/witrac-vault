<?php

namespace App\Vault\Controller\File\Create;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Witrac\Shared\Infrastructure\Symfony\Validation\ValidationFailedException;

final class CreateFileValidation
{
    /**
     * @throws ValidationFailedException
     */
    public static function validated(Request $request, ParameterBagInterface $bag): void
    {
        $constraints = new Assert\Collection([
            'file' => [new Assert\File(['maxSize' => $bag->get('max_file_size')])],
            'library' => [new Assert\Uuid(['versions' => [Assert\Uuid::V4_RANDOM]])],
        ]);

        $errors = Validation::createValidator()->validate(
            array_merge($request->request->all(), $request->files->all()),
            $constraints
        );

        if ($errors->count()) {
            throw new ValidationFailedException($errors);
        }
    }
}
