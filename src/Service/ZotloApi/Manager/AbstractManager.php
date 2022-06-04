<?php


namespace App\Service\ZotloApi\Manager;


use App\Service\ZotloApi\ZotloApiClient;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AbstractManager
{
    protected ZotloApiClient $client;

    public function __construct(ZotloApiClient $client)
    {
        $this->client = $client;
    }

    public function checkResponse($response)
    {
        if ($response['meta']['httpStatus'] !== 200) {
            throw new BadRequestException($response['meta']['errorMessage']);
        }
    }

}