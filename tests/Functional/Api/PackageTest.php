<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Package;

final class PackageTest extends ApiTestCase
{
  use AuthenticatedClientTrait;

  public function testAssertCollection(): void
  {
    $client = static::createAuthenticatedClient('superadmin@s2h.corp');
    $response = $client->request('GET', '/api/packages?softdeleteable=0');
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(200);
//    $this->assertGreaterThan(0, $response->toArray()['hydra:totalItems']);
//    $response = $client->request('GET', '/api/packages?name=Package deux');
//    $this->assertResponseIsSuccessful();
//    $this->assertResponseStatusCodeSame(200);
//    $this->assertGreaterThan(0, $response->toArray()['hydra:totalItems']);
//    $mainResponse = $response->toArray()['hydra:member'][0];
//    $packageFeatures = $mainResponse['packageFeatures'];
//      $this->assertCount(2, $packageFeatures);
//      $packageVersions = $mainResponse['packageVersions'];
//      $this->assertCount(2, $packageVersions);
//    $this->assertArrayHasKey('id', $packageVersions[0]);
//    $currentVersion = $mainResponse['currentPackageVersion'];
//    $this->assertSame(2, $currentVersion['number']);
    
  }

  /**
   * @dataProvider provideDataPackages
   */
  public function testDeletePackageFailedBecauseAlreadyUsed(array $data): void
  {
    $client = static::createAuthenticatedClient($data['username']);
    $iriPackage = $this->findIriBy(Package::class, ['name' => $data['packageName']]);
    $client->request('DELETE', $iriPackage);
    $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    $this->assertJsonContains([
      'hydra:description' => $data['message'],
    ]);
  }

  public function provideDataPackages(): iterable
  {

    $defaultData = static fn (array $data) => array_merge([
      'packageName' => '',
      'username' => 'superadmin@s2h.corp',
      'message' => 'Ce package ne peut être supprimé car il est en cours d\'utilisation.',
    ], $data);

    yield 'Package un is used' => [$defaultData(['packageName' => 'Package un'])];
    yield 'Package deux is used' => [$defaultData(['packageName' => 'Package deux'])];

    yield 'Package un cannot be deleted by a manager' => [
      $defaultData(
        [
          'packageName' => 'Package un', 'username' => 'admin@s2h.corp', 'message' => 'Vous n\'avez pas les droits suffisants'
        ]
      )
    ];

    yield 'Package deux cannot be deleted by a manager' => [
      $defaultData(
        [
          'packageName' => 'Package deux', 'username' => 'admin@s2h.corp', 'message' => 'Vous n\'avez pas les droits suffisants'
        ]
      )
    ];

    yield 'Package deux cannot be deleted by a gestionnaire' => [
      $defaultData(
        [
          'packageName' => 'Package deux', 'username' => 'gestionnaire@s2h.corp', 'message' => 'Vous n\'avez pas les droits suffisants'
        ]
      )
    ];
  }

  public function testDeletePackageSuccessful(): void
  {
    $client = static::createAuthenticatedClient('superadmin@s2h.corp');
    $iriPackage = $this->findIriBy(Package::class, ['name' => 'Package trois']);
    $client->request('DELETE', $iriPackage);
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(204);
  }
}
