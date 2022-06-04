<?php


namespace App\Service\Validation\Constraint;

use Symfony\Component\Validator\Constraints;

class AuthConstraint
{
    public static function loginRules(): Constraints\Collection
    {
        return new Constraints\Collection(
            [
                'email' => new Constraints\Email(['message' => 'Please fill in valid email']),
            ]
        );
    }

    public static function registerRules(): Constraints\Collection
    {
        return new Constraints\Collection(
            [
                'email' => new Constraints\Email(['message' => 'Please fill in valid email']),
                'firstName' => new Constraints\NotBlank(),
                'lastName' => new Constraints\NotBlank(),
                'country' => new Constraints\NotBlank(),
                'phoneNumber' => new Constraints\NotBlank(),
            ]
        );
    }
}
