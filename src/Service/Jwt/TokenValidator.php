<?php


namespace App\Service\Jwt;


use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class TokenValidator
 * @package App\Service\Jwt
 */
class TokenValidator
{
    public function validate($jwt){
        $key = InMemory::plainText('yusufdogan');
        $configuration = Configuration::forSymmetricSigner(new Sha256(), $key);
        $configuration->setValidationConstraints(
            new SignedWith(
                new Sha256(),
                InMemory::plainText('yusufdogan')
            )
        );
        $token = $configuration->parser()->parse($jwt);
        assert($token instanceof UnencryptedToken);
        $constraints = $configuration->validationConstraints();
        try {
            $configuration->validator()->assert($token, ...$constraints);
        } catch (RequiredConstraintsViolated $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
