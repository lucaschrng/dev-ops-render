<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

/**
 * @group mess
 */
final class MessagesClientTest extends ApiTestCase
{
  use AuthenticatedClientTrait;
  private const NO_REPLY_EMAIL = 'superadmin@s2h.corp';

  public function testAssertCollection(): void
  {
    $client = static::createAuthenticatedClient('superadmin@s2h.corp');
    $response = $client->request(
      'GET',
      "/api/messages_clients?properties[]=id&properties[]=isRead&properties[]=sender&properties[]=recipient",
    );
    $this->assertResponseIsSuccessful();
    $result = $response->toArray()['hydra:member'];
    $this->assertCount(4, $result);

    $response = $client->request(
      'GET',
      "/api/messages_clients?properties[]=id&properties[]=isRead&properties[]=sender&properties[]=recipient&isRead=1",
    );
    $this->assertResponseIsSuccessful();
    $result = $response->toArray()['hydra:member'];
    $this->assertCount(1, $result);
  }
   
}
