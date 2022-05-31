<?php


namespace App\Service\Jwt;


use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

// @todo container'a alınacak
class TokenGenerator
{

    public function generate($payload)
    {
        $key = InMemory::plainText('yusufdogan');
        $configuration = Configuration::forSymmetricSigner(new Sha256(), $key);

        return $configuration->builder()
            ->withClaim('payload', $payload)
            // @todo burada nasıl farklı bir header verilebilir kontrol edilecek.
            ->withClaim('headers', ['test' => 'test'])
            ->getToken($configuration->signer(), $configuration->signingKey())
            ->toString();
    }

}
