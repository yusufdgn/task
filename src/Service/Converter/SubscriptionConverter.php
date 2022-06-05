<?php


namespace App\Service\Converter;


use App\Entity\Subscription;

class SubscriptionConverter implements ConverterInterface
{

    /**
     * @param $response
     * @param Subscription $subscriptionEntity
     * @return Subscription
     * @throws \Exception
     */
    public function convertResponseToEntity($response, $subscriptionEntity): Subscription
    {
        $subscriptionEntity->setSubscriberId($response['profile']['subscriberId']);
        $subscriptionEntity->setStatus($response['profile']['status']);
        $subscriptionEntity->setRealStatus($response['profile']['realStatus']);
        $subscriptionEntity->setCanceled(false);
        $subscriptionEntity->setStartDate(new \DateTime($response['profile']['startDate']));
        $subscriptionEntity->setExpireDate(new \DateTime($response['profile']['expireDate']));
        $subscriptionEntity->setQuantity($response['profile']['quantity']);
        $subscriptionEntity->setPendingQuantity($response['profile']['pendingQuantity']);
        $subscriptionEntity->setPackageId($response['package']['packageId']);
        $subscriptionEntity->setPrice($response['package']['price']);
        $subscriptionEntity->setCurrency($response['package']['currency']);

        if ($response['profile']['cancellation'] === null) {
            return $subscriptionEntity;
        }

        $subscriptionEntity->setCanceled(true);
        $subscriptionEntity->setCancellationCode($response['profile']['cancellation']['code']);
        $subscriptionEntity->setCancellationDate(new \DateTime($response['profile']['cancellation']['date']));
        $subscriptionEntity->setCancellationReason($response['profile']['cancellation']['reason']);

        return $subscriptionEntity;
    }
}