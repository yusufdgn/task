<?php


namespace App\Service;


use App\Entity\Subscriber;
use App\Service\Validation\Constraint\AuthConstraint;
use App\Service\Validation\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ValidationService
     */
    private ValidationService $validationService;

    /**
     * @var TokenService
     */
    private TokenService $tokenService;

    /**
     * AuthService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, ValidationService $validationService, TokenService $tokenService)
    {
        $this->entityManager = $entityManager;
        $this->validationService = $validationService;
        $this->tokenService = $tokenService;
    }

    /**
     * @param $subscriberData
     * @return Subscriber
     */
    public function createSubscriber($subscriberData): Subscriber
    {
        $this->validationService->validate($subscriberData, AuthConstraint::registerRules());
        $subscriber = new Subscriber();
        $subscriber->setEmail($subscriberData['email']);
        $subscriber->setCountry($subscriberData['country']);
        $subscriber->setFirstName($subscriberData['firstName']);
        $subscriber->setLastName($subscriberData['lastName']);
        $subscriber->setPhoneNumber($subscriberData['phoneNumber']);
        $subscriber->setUniqueId(Uuid::fromString(Uuid::uuid4())->toString());
        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();

        return $subscriber;
    }

    /**
     * @param $email
     * @return Subscriber
     */
    public function getSubscriber($email): Subscriber
    {
        $subscriber = $this->entityManager->getRepository(Subscriber::class)->findOneBy(['email' => $email]);
        if ($subscriber === null) {
            throw new BadRequestException("Subscriber not found");
        }

        return $subscriber;
    }

    /**
     * @param $content
     * @return string
     */
    public function generateSubscriberToken($content): string
    {
        $this->validationService->validate($content, AuthConstraint::loginRules());
        $subscriber = $this->getSubscriber($content['email']);
        return $this->tokenService->generate(['email' => $subscriber->getEmail(), 'subscriberId' => $subscriber->getUniqueId()]);
    }

}