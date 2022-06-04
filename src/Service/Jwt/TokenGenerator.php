<?php

namespace App\Service\Jwt;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

/**
 * Class TokenGenerator
 * @package App\Service\Jwt
 */
class TokenGenerator
{

    public function generate($payload)
    {
        $key = InMemory::plainText('yusufdogan');
        $configuration = Configuration::forSymmetricSigner(new Sha256(), $key);

        return $configuration->builder()
            ->withClaim('payload', $payload)
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();
    }

}
