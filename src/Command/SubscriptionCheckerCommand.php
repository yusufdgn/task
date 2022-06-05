<?php


namespace App\Command;


use App\Entity\Subscription;
use App\Service\SubscriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Doctrine\ORM\QueryBuilder;

/**
 * Class SubscriptionCheckerCommand
 * @package App\Command
 */
class SubscriptionCheckerCommand extends Command
{

    protected static $defaultName = 'app:subscription-checker';

    private EntityManagerInterface $entityManager;

    private SubscriptionService $subscriptionService;

    public function __construct(EntityManagerInterface $entityManager, SubscriptionService $subscriptionService, string $name = null)
    {
        $this->entityManager = $entityManager;
        $this->subscriptionService = $subscriptionService;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $subscriptionRepository = $this->entityManager->getRepository(Subscription::class);
        $subscriptions = $subscriptionRepository->getAllActiveSubscriptions();
        if (empty($subscriptions)) {
            return 1;
        }

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription) {
            $subscriptionResponse = $this->subscriptionService->getSubscription($subscription->getSubscriberId());
            if (!isset($subscriptionResponse['result'])) {
                continue;
            }

            $subscription = $this->subscriptionService->assignResponseToEntity($subscriptionResponse['result'], $subscription);
            $this->entityManager->persist($subscription);
        }
        $this->entityManager->flush();

        return 1;
    }
}