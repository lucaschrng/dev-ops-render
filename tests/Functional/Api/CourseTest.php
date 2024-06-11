<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

final class CourseTest extends ApiTestCase
{
  use AuthenticatedClientTrait;

  public function testAssertCollectionCourses(): void
  {
    $client = static::createAuthenticatedClient('superadmin@s2h.corp');
    $response = $client->request('GET', '/api/courses');
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(200);
    $this->assertEquals(12, $response->toArray()['hydra:totalItems']);

    $client = static::createAuthenticatedClient('user@s2h.corp');
    $response = $client->request('GET', '/api/courses');
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(200);
    $nbresult = $response->toArray()['hydra:totalItems'];
    $this->assertEquals(0,  $nbresult);
  }
}
