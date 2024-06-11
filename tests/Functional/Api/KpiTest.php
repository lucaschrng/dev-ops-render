<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

/**
 * @group kpi
 */
final class KpiTest extends ApiTestCase
{
  use AuthenticatedClientTrait;

  public function testAssertCollection(): void
  {
    $email = 'superadmin@s2h.corp';
    $client = static::createAuthenticatedClient($email);

    $response = $client->request('GET', "/api/profiles?user.email=${email}")->toArray();
    $this->assertEquals(1, $response['hydra:totalItems']);
    $response = $response['hydra:member'][0];
    $idprofile = $response['id'];
    $response = $client->request('GET', "/api/profiles/${idprofile}/kpi")->toArray();
    
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(200);

    $keys = [
      'list_profile', 'nbAllProfiles', 'profile', 'userRequest', 'count_request_in_progress', 'count_request_vip',
      'messages', 'count_msg_no_read', 'cnt_booking_month', 'cnt_booking_month_profile', 'cnt_simulation_month', 'bri'
    ];

    $profile = $response['profile'];
    $this->assertArrayHasKey('id', $profile);
    $this->assertArrayHasKey('code', $profile);
    $this->assertSame($idprofile, $profile['id']);
    $this->assertSame('admin super', $profile['lastname']);

      $this->assertCount(5, $response['userRequest']);
      $this->assertEquals(5, $response['count_request_in_progress']);
      $this->assertEquals(2, $response['count_request_vip']);

    foreach ($keys as $key) {
      $this->assertArrayHasKey($key, $response);
    }
    $this->assertCount(3, $response['messages']);
    $this->assertEquals(3, $response['count_msg_no_read']['count_unread_messages']);

    $this->assertEquals(3, $response['cnt_booking_month_profile']);
    $this->assertEquals(4, $response['cnt_booking_month']);
    $this->assertEquals(1, $response['cnt_simulation_month']);
  }
}
