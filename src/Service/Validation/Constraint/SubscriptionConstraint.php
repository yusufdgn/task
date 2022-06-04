<?php


namespace App\Service\Validation\Constraint;


use Symfony\Component\Validator\Constraints;

class SubscriptionConstraint
{
    public static function creditCardRules(): Constraints\Collection
    {
        return new Constraints\Collection(
            [
                'cardNo' => new Constraints\CardScheme([
                    Constraints\CardScheme::AMEX,
                    Constraints\CardScheme::VISA,
                    Constraints\CardScheme::MAESTRO,
                    Constraints\CardScheme::MASTERCARD,
                    Constraints\CardScheme::DISCOVER,
                    Constraints\CardScheme::INSTAPAYMENT,
                    Constraints\CardScheme::CHINA_UNIONPAY,
                ]),
                'cardOwner' => new Constraints\NotBlank(),
                'expireMonth' => new Constraints\Range(['min' => 1, 'max' => 12]),
                'expireYear' => new Constraints\Range(['min' => 22, 'max' => 99]),
                'cvv' => new Constraints\Length(['min' => 3, 'max' => 4]),
            ]
        );
    }
}