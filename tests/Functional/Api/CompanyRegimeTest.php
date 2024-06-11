<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Company;
use App\Entity\CompanyRegime;


final class CompanyRegimeTest extends ApiTestCase
{
  use AuthenticatedClientTrait;

  public function testAddCompanyRegime(): void
  {
      $client = static::createAuthenticatedClient('superadmin@s2h.corp');
      $client->request('POST', '/api/company_regimes', [
          'json' => [
              "libelleRegime" => "Régime Ernest",
              "prctRendement" => 5,
              "prctRendementDefault" => 0.0,
              "prctFrais" => 4,
              "prctFraisDefault" => 0.0,
              "csp" => "1;régime cadre;20;40;5;",
              "company" => $this->findIriBy(Company::class, ['slug' => 'ernest']),
          ]]);
           $this->assertResponseStatusCodeSame(201);
  }

    public function testAddCompanyRegimeBadParameters(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $client->request('POST', '/api/company_regimes', [
            'json' => [
                "libelleRegime" => "Régime Diot Siaci",
                "prctRendement" => 5,
                "prctRendementDefault" => "0.0",
                "prctFrais" => 4,
                "prctFraisDefault" => "0.0",
                "csp" => "1;régime cadre;20;40;5;",
                "company" => $this->findIriBy(Company::class, ['siren' => '123456789']),
            ]]);
        $this->assertResponseStatusCodeSame(400);
    }

    public function testAddCompanyRegimeExists(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $client->request('POST', '/api/company_regimes', [
            'json' => [
                "libelleRegime" => "Régime 2",
                "prctRendement" => 5,
                "prctRendementDefault" => 0.0,
                "prctFrais" => 4,
                "prctFraisDefault" => 0.0,
                "csp" => "1;régime cadre;20;40;5;",
                "company" => $this->findIriBy(Company::class, ['siren' => '123456777']),
            ]]);
         $this->assertResponseStatusCodeSame(500);
    }

    public function testUpdateCompanyRegime(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $companyRegime = $this->findIriBy(CompanyRegime::class, ['libelleRegime' => 'Regime entreprise A1']);
        $client->request('PATCH', $companyRegime, [
            'json' => [
                "libelleRegime" => "Régime Update",
                "prctRendement" => "6",
                "prctRendementDefault" => 0.0,
                "prctFrais" => "5",
                "prctFraisDefault" => 0.0,
                "csp" => "1;régime cadre;20;40;5;",
                "company" => $this->findIriBy(Company::class, ['siren' => '123456777']),
            ]]);
        $this->assertResponseStatusCodeSame(415);
    }
}
