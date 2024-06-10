<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Package;

final class PermissionTest extends ApiTestCase
{
  use AuthenticatedClientTrait;

  public function testAssertCollection(): void
  {
    $client = static::createAuthenticatedClient('user@s2h.corp');
    $result = $client->request('GET', '/api/permissions')->toArray();
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(200);
    $firstPackage = $result['hydra:member'][0];
    $packageFeatures = $firstPackage['services']['packageFeatures'];
    $this->assertArrayHasKey('packageId', $packageFeatures[1]);
    $this->assertArrayHasKey('featureId', $packageFeatures[1]);
    $this->assertArrayHasKey('canUseFeature', $packageFeatures[1]);
    $this->assertArrayHasKey('profileId', $packageFeatures[1]);
    $this->assertTrue($packageFeatures[1]['canUseFeature']);
    $this->assertSame('e-learning', $packageFeatures[1]['featureSlug']);
    $this->assertCount(2, $packageFeatures);
  }
}
