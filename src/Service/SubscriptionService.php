<?php


namespace App\Service;

use App\Entity\Subscriber;
use App\Entity\Subscription;
use App\Service\Converter\SubscriptionConverter;
use App\Service\Validation\Constraint\SubscriptionConstraint;
use App\Service\Validation\ValidationService;
use App\Service\ZotloApi\Manager\SubscriptionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Class SubscriptionService
 * @package App\Service
 */
class SubscriptionService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var SubscriptionManager
     */
    private SubscriptionManager $subscriptionManager;

    /**
     * @var ValidationService
     */
    private ValidationService $validationService;

    /**
     * @var SubscriptionConverter
     */
    private SubscriptionConverter $subscriptionConverter;

    /**
     * SubscriptionService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidationService $validationService
     * @param SubscriptionManager $subscriptionManager
     * @param SubscriptionConverter $subscriptionConverter
     */
    public function __construct(EntityManagerInterface $entityManager, ValidationService $validationService, SubscriptionManager $subscriptionManager, SubscriptionConverter $subscriptionConverter)
    {
        $this->entityManager = $entityManager;
        $this->subscriptionManager = $subscriptionManager;
        $this->validationService = $validationService;
        $this->subscriptionConverter = $subscriptionConverter;
    }

    /**
     * @param $subscriberId
     * @param $creditCardData
     * @return mixed
     * @throws \Exception
     */
    public function createSubscription($subscriberId, $creditCardData)
    {
        $this->validationService->validate($creditCardData, SubscriptionConstraint::creditCardRules());

        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneBy(['subscriberId' => $subscriberId, 'status' => 'active']);
        if ($subscription !== null) {
            throw new BadRequestException("Subscriber has already an active subscription.");
        }
        $subscriptionData = $this->addSubscriberData($subscriberId, $creditCardData);
        $subscriptionData = $this->addDefaultSubscriptionData($subscriptionData);

        $response = $this->subscriptionManager->create($subscriptionData)['result'];
        $subscription = $this->assignResponseToEntity($response, new Subscription());
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();

        return $response;
    }

    /**
     * @throws \Exception
     */
    public function hookUpdateSubscription($subscriptionHookData)
    {
        $subscriptionHookData = $subscriptionHookData['parameters'];
        $originalTransactionId = $subscriptionHookData['profile']['originalTransactionId'];
        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneBy(['originalTransactionId' => $originalTransactionId]);
        if ($subscription === null) {
            throw new BadRequestException("Subscriber has not an any subscription");
        }

        $subscription = $this->assignResponseToEntity($subscriptionHookData, $subscription);
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
    }


    /**
     * @param $subscriberId
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     */
    public function getSubscription($subscriberId)
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneBy(['subscriberId' => $subscriberId]);
        if ($subscription == null) {
            throw new BadRequestException("Subscriber has not an any subscription.");
        }

        return $this->subscriptionManager->get($subscriberId, 'zotlo.premium');
    }

    /**
     * @param $subscriberId
     * @param $deleteData
     * @return mixed
     * @throws \Exception
     */
    public function deleteSubscription($subscriberId, $deleteData)
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneBy(['subscriberId' => $subscriberId, 'realStatus' => 'active']);
        if ($subscription === null) {
            throw new BadRequestException("Subscriber has not an active subscription.");
        }

        $data = [
            "subscriberId" => $subscriberId,
            "packageId" => "zotlo.premium",
            "cancellationReason" => $deleteData['cancellationReason'],
            "force" => $deleteData['force'],
        ];

        $response = $this->subscriptionManager->delete($data)['result'];
        $subscription = $this->assignResponseToEntity($response, $subscription);
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
        return $response;
    }

    /**
     * @param $response
     * @param $subscription
     * @return Subscription
     * @throws \Exception
     */
    public function assignResponseToEntity($response, $subscription): Subscription
    {
        return $this->subscriptionConverter->convertResponseToEntity($response, $subscription);
    }

    /**
     * @param $subscriberId
     * @param $subscriptionData
     * @return array
     */
    protected function addSubscriberData($subscriberId, $subscriptionData): array
    {
        /** @var Subscriber $subscriber */
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->findOneBy(['uniqueId' => $subscriberId]);
        return array_merge(
            [
                "subscriberPhoneNumber" => $subscriber->getPhoneNumber(),
                "subscriberFirstname" => $subscriber->getFirstName(),
                "subscriberLastname" => $subscriber->getLastName(),
                "subscriberEmail" => $subscriber->getEmail(),
                "subscriberId" => $subscriber->getUniqueId(),
                "subscriberIpAddress" => $_SERVER['REMOTE_ADDR'],
                "subscriberCountry" => "TR"
            ], $subscriptionData
        );

    }

    /**
     * @param $subscriptionData
     * @return array|int[]|string[]|\string[][]
     */
    protected function addDefaultSubscriptionData($subscriptionData)
    {
        return array_merge([
            "language" => "tr",
            "packageId" => "zotlo.premium",
            "platform" => "ios",
            "cardToken" => "",
            "quantity" => 1,
            "force3ds" => 0,
            "discountPercent" => 0,
            "redirectUrl" => "https://example.com/zotlo-callback",
            "customParameters" => [
                "source" => "Landing",
                "country" => "TR"
            ]
        ], $subscriptionData);
    }
}