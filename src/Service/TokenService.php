<?php


namespace App\Service;


use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TokenService
{
    const PRIVATE_KEY = 'yusuf.dogan';

    /**
     * @var Configuration
     */
    public Configuration $configuration;

    public function __construct()
    {
        $privateKey = InMemory::plainText(self::PRIVATE_KEY);
        $this->configuration = Configuration::forSymmetricSigner(new Sha256(), $privateKey);
        $this->configuration->setValidationConstraints(
            new SignedWith(
                new Sha256(),
                $privateKey
            )
        );
    }

    /**
     * @param $payload
     * @return string
     */
    public function generate($payload): string
    {
        return $this->configuration->builder()
            ->withClaim('payload', $payload)
            ->getToken($this->configuration->signer(), $this->configuration->signingKey())
            ->toString();
    }

    /**
     * @param $jwtToken
     */
    public function validate($jwtToken)
    {
        /** @var UnencryptedToken $unencryptedToken */
        $unencryptedToken = $this->getUnencryptedToken($jwtToken);
        $constraints = $this->configuration->validationConstraints();
        try {
            $this->configuration->validator()->assert($unencryptedToken, ...$constraints);
        } catch (RequiredConstraintsViolated $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @param $jwtToken
     * @return Token|UnencryptedToken
     */
    public function getUnencryptedToken($jwtToken)
    {
        $unEncryptedToken = $this->configuration->parser()->parse($jwtToken);
        assert($unEncryptedToken instanceof UnencryptedToken);
        return $unEncryptedToken;
    }

    /**
     * @param $tokenHeader
     * @return string|null
     */
    public function getJwtOnAuthorizationHeader($tokenHeader): ?string
    {
        $authorizationKeys = explode(' ', $tokenHeader);
        if (count($authorizationKeys) !== 2) {
            throw new BadRequestException("Authorization Needed!");
        }

        if ($authorizationKeys[0] !== 'Bearer') {
            throw new BadRequestException("Authorization header value not valid!");
        }

        return $authorizationKeys[1];
    }

    /**
     * @param $jwtToken
     * @param $payloadKey
     * @return string|null
     */
    public function getJwtPayload($jwtToken, $payloadKey): ?string
    {
        $payload = $this->getAllClaims($jwtToken)['payload'] ?? null;
        if ($payload == null) {
            return null;
        }

        foreach ($payload as $key => $value) {
            if ($payloadKey === $key) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param $jwtToken
     * @return array
     */
    public function getAllClaims($jwtToken): array
    {
        return $this->getUnencryptedToken($jwtToken)->claims()->all();
    }
}