<?php


namespace App\Service;


use App\Service\ZotloApi\Manager\CreditCardManager;
use Doctrine\ORM\EntityManagerInterface;

class CreditCardService
{
    private EntityManagerInterface $entityManager;

    private CreditCardManager $creditCardManager;

    public function __construct(EntityManagerInterface $entityManager, CreditCardManager $creditCardManager)
    {
        $this->entityManager = $entityManager;
        $this->creditCardManager = $creditCardManager;
    }

    public function getCreditCards($subscriberId)
    {
        $response = $this->creditCardManager->getAll($subscriberId);
        return $response['result']['cardList'];
    }
}