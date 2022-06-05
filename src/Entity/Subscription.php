<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SubscriptionRepository;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * Class Subscription
 * @package App\Entity
 */
class Subscription
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    public int $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    public string $subscriberId;

    /**
     * @ORM\Column(type="string", length=16)
     */
    public string $status;

    /**
     * @ORM\Column(type="string", length=16)
     */
    public string $realStatus;

    /**
     * @ORM\Column(type="datetime")
     */
    public \DateTime $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    public \DateTime $expireDate;

    /**
     * @ORM\Column(type="boolean")
     */
    public bool $canceled;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?\DateTime $cancellationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public ?string $cancellationReason;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    public ?string $cancellationCode;

    /**
     * @ORM\Column(type="float")
     */
    public int $quantity;

    /**
     * @ORM\Column(type="float")
     */
    public int $pendingQuantity;

    /**
     * @ORM\Column(type="string", length=32)
     */
    public string $packageId;

    /**
     * @ORM\Column(type="float")
     */
    public float $price;

    /**
     * @ORM\Column(type="string", length=32)
     */
    public string $currency;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?\DateTime $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public ?\DateTime $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSubscriberId(): string
    {
        return $this->subscriberId;
    }

    /**
     * @param string $subscriberId
     */
    public function setSubscriberId(string $subscriberId): void
    {
        $this->subscriberId = $subscriberId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getRealStatus(): string
    {
        return $this->realStatus;
    }

    /**
     * @param string $realStatus
     */
    public function setRealStatus(string $realStatus): void
    {
        $this->realStatus = $realStatus;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getExpireDate(): \DateTime
    {
        return $this->expireDate;
    }

    /**
     * @param \DateTime $expireDate
     */
    public function setExpireDate(\DateTime $expireDate): void
    {
        $this->expireDate = $expireDate;
    }

    /**
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->canceled;
    }

    /**
     * @param bool $canceled
     */
    public function setCanceled(bool $canceled): void
    {
        $this->canceled = $canceled;
    }

    /**
     * @return \DateTime|null
     */
    public function getCancellationDate(): ?\DateTime
    {
        return $this->cancellationDate;
    }

    /**
     * @param \DateTime|null $cancellationDate
     */
    public function setCancellationDate(?\DateTime $cancellationDate): void
    {
        $this->cancellationDate = $cancellationDate;
    }

    /**
     * @return string|null
     */
    public function getCancellationReason(): ?string
    {
        return $this->cancellationReason;
    }

    /**
     * @param string|null $cancellationReason
     */
    public function setCancellationReason(?string $cancellationReason): void
    {
        $this->cancellationReason = $cancellationReason;
    }

    /**
     * @return string|null
     */
    public function getCancellationCode(): ?string
    {
        return $this->cancellationCode;
    }

    /**
     * @param string|null $cancellationCode
     */
    public function setCancellationCode(?string $cancellationCode): void
    {
        $this->cancellationCode = $cancellationCode;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getPendingQuantity(): int
    {
        return $this->pendingQuantity;
    }

    /**
     * @param int $pendingQuantity
     */
    public function setPendingQuantity(int $pendingQuantity): void
    {
        $this->pendingQuantity = $pendingQuantity;
    }

    /**
     * @return string
     */
    public function getPackageId(): string
    {
        return $this->packageId;
    }

    /**
     * @param string $packageId
     */
    public function setPackageId(string $packageId): void
    {
        $this->packageId = $packageId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTime();
    }

}