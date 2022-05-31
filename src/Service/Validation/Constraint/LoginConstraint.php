<?php


namespace App\Service\Validation\Constraint;

use Symfony\Component\Validator\Constraints;

class LoginConstraint
{
    public static function rules(): Constraints\Collection
    {
        return new Constraints\Collection(
            [
                'email' => new Constraints\Email(['message' => 'Please fill in valid email']),
            ]
        );
    }
}
