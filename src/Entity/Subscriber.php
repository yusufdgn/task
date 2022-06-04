<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * Class Subscriber
 * @package App\Entity
 */
class Subscriber
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
    public string $uniqueId;

    /**
     * @ORM\Column(type="string", length=64)
     */
    public string $email;

    /**
     * @ORM\Column(type="string", length=32)
     */
    public string $firstName;

    /**
     * @ORM\Column(type="string", length=32)
     */
    public string $lastName;

    /**
     * @ORM\Column(type="string", length=32)
     */
    public string $country;

    /**
     * @ORM\Column(type="string", length=32)
     */
    public string $phoneNumber;


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
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId(string $uniqueId): void
    {
        $this->uniqueId = $uniqueId;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "email" => $this->getEmail(),
            "country" => $this->getCountry(),
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "phoneNumber" => $this->getPhoneNumber(),
            "uniqueId" => $this->getUniqueId(),
        ];
    }
}