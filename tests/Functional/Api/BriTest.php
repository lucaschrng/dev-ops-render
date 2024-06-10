<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Company;
use App\Entity\CompanyRegime;


/**
 * @group bri
 */
final class BriTest extends ApiTestCase
{
  use AuthenticatedClientTrait;

  public function testBri(): void
  {
      $client = static::createAuthenticatedClient('superadmin@s2h.corp');

      $response = $client->request('GET', '/api/bri_report')->toArray();
      $resultBris = $response['hydra:member'];
      $briNb = $response['hydra:totalItems'];
      $this->assertResponseIsSuccessful();
      $this->assertResponseStatusCodeSame(200);
      $this->assertEquals(6,  $briNb);

      $this->assertSame('Entreprise-A1', $resultBris[0]['label']);
      $this->assertSame('User Bilan', $resultBris[0]['firstname'].' '.$resultBris[0]['lastname']);
      $this->assertSame('010106', $resultBris[0]['registrationNumber']);
      $this->assertSame('BilanUser', $resultBris[0]['name']);
      $this->assertSame('TU Eligible', $resultBris[0]['eligible']);
      $this->assertSame('TU type accompagnement', $resultBris[0]['TypeAccompagnement']);
      $this->assertSame('TU doer', $resultBris[0]['doer']);
      $this->assertSame('TU reviewer', $resultBris[0]['reveiwer']);
      $this->assertSame('TU comment', $resultBris[0]['comment']);

      $this->assertSame('Questionnaire TU', $resultBris[0]['titre_statut']);
      $this->assertSame('User Bilan', $resultBris[0]['updatedByFirstname'].' '.$resultBris[0]['updatedByLastName']);
      $this->assertSame('Dossier déposé TU', $resultBris[1]['titre_statut']);
      $this->assertSame('User Bilan', $resultBris[1]['updatedByFirstname'].' '.$resultBris[1]['updatedByLastName']);
      $this->assertSame('Dossier complet TU', $resultBris[2]['titre_statut']);
      $this->assertSame('super admin super', $resultBris[2]['updatedByFirstname'].' '.$resultBris[2]['updatedByLastName']);
      $this->assertSame('Dossier incomplet TU', $resultBris[3]['titre_statut']);
      $this->assertSame('super admin super', $resultBris[3]['updatedByFirstname'].' '.$resultBris[3]['updatedByLastName']);
      $this->assertSame('Dossier restitué TU', $resultBris[4]['titre_statut']);
      $this->assertSame('super admin super', $resultBris[4]['updatedByFirstname'].' '.$resultBris[4]['updatedByLastName']);
      $this->assertSame('Dossier terminé TU', $resultBris[5]['titre_statut']);
      $this->assertSame('super admin super', $resultBris[5]['updatedByFirstname'].' '.$resultBris[5]['updatedByLastName']);
  }

    public function testBriQA(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');

        $response = $client->request('GET', '/api/bri_report_qa')->toArray();

        $resultBris = $response['hydra:member'];
        $briNb = $response['hydra:totalItems'];
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals(18,  $briNb);

        $this->assertSame('Entreprise-A1', $resultBris[0]['label']);
        $this->assertSame('User Bilan', $resultBris[0]['firstname'].' '.$resultBris[0]['lastname']);
        $this->assertSame('BilanUser', $resultBris[0]['name']);
        $this->assertSame('TU doer', $resultBris[0]['doer']);
        $this->assertSame('TU reviewer', $resultBris[0]['reveiwer']);
//        $this->assertSame('radio-group-1671630143724-0', $resultBris[1]['question']);
//        $this->assertSame('option-1', $resultBris[1]['answer']);
//        $this->assertSame('radio-group-1671630161519-0', $resultBris[2]['question']);
//        $this->assertSame('option-1', $resultBris[2]['answer']);

    }
}
