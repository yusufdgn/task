<?php


namespace App\Service\ZotloApi\Manager;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class CreditCardManager
 * @package App\Service\ZotloApi
 */
class CreditCardManager extends AbstractManager implements ManagerInterface
{
    public function getAll($subscriberId)
    {
        /** @var ResponseInterface $response */
        $response = $this->client->request('subscription/card-list?subscriberId=' . $subscriberId, 'GET');
        $this->checkResponse($response);
        return $response;
    }

}