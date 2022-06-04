<?php


namespace App\Service\ZotloApi\Manager;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class SubscriptionManager
 * @package App\Service\ZotloApi
 */
class SubscriptionManager extends AbstractManager implements ManagerInterface
{

    public function create($data)
    {
        /** @var ResponseInterface $response */
        $response = $this->client->request('payment/credit-card', 'POST', $data);
        $this->checkResponse($response);
        return $response;
    }

    public function get($subscriberId, $packageType)
    {
        /** @var ResponseInterface $response */
        $response = $this->client->request('subscription/profile?subscriberId=' . $subscriberId . '&packageId=' . $packageType, 'GET');
        $this->checkResponse($response);
        return $response;
    }

    public function delete($data)
    {
        /** @var ResponseInterface $response */
        $response = $this->client->request('subscription/cancellation', 'POST', $data);
        $this->checkResponse($response);
        return $response;
    }


}