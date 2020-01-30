<?php

declare(strict_types=1);

namespace app\core\services\auth\dto;

class UserDetails
{
    /**
     * @var string|int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|int $id
     *
     * @return UserDetails
     */
    public function setId($id): UserDetails
    {
        $this->id = $id;

        return $this;
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
     *
     * @return UserDetails
     */
    public function setFirstName(string $firstName): UserDetails
    {
        $this->firstName = $firstName;

        return $this;
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
     *
     * @return UserDetails
     */
    public function setLastName(string $lastName): UserDetails
    {
        $this->lastName = $lastName;

        return $this;
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
     *
     * @return UserDetails
     */
    public function setEmail(string $email): UserDetails
    {
        $this->email = $email;

        return $this;
    }
}