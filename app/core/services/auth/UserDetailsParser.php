<?php

declare(strict_types=1);

namespace app\core\services\auth;

use app\core\services\auth\dto\UserDetails;
use yii\authclient\ClientInterface;

final class UserDetailsParser
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns structured information about the user from external services
     *
     * @return UserDetails
     */
    public function parseUserDetails(): UserDetails
    {
        // required values
        $details = new UserDetails();

        // get data from response
        $data = $this->client->getUserAttributes();
        // get external service name
        $service = $this->client->getName();

        // set user's data: external id, email
        $details
            ->setId($data['id'])
            ->setEmail($data['email']);

        // see docs for details about response key names
        switch ($service) {
            case 'google':
                $details
                    ->setFirstName($data['given_name'])
                    ->setLastName($data['family_name']);
                break;
            case 'facebook':
            case 'github':
                [$firstName, $lastName] = explode(' ', $data['name']);

                $details
                    ->setFirstName($firstName)
                    ->setLastName($lastName);
                break;
            case 'vkontakte':
                $details
                    ->setFirstName($data['first_name'])
                    ->setLastName($data['last_name']);
                break;
        }

        return $details;
    }
}