<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\DataFixtures\UserFixtures;

trait AuthenticatedClientTrait
{
  public static function createAuthenticatedClient(string $email): Client
  {
    $token = static::createClient()->request('POST', '/api/login_check', [
      'json' => array(
          'username' => $email,
          'password' => AuthenticatedClientTrait::getDefaultPassword(),
      )
    ])->toArray()['token'];

    return static::createClient([], [
      'headers' => [
        'Authorization' => sprintf('Bearer %s', $token),
      ],
    ]);
  }

  public static function getDefaultPassword(): string
  {
      return 'Summer2015';
  }
}
