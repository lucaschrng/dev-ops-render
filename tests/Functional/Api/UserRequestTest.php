<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Profile;
use App\Entity\UserRequest;
use App\Entity\UserRequestChannel;
use App\Entity\UserRequestMotif;
use App\Entity\UserRequestTypology;

/**
 * @group urequest
 */
final class UserRequestTest extends ApiTestCase
{
    use AuthenticatedClientTrait;
    public function testAssertCollection(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request(
          'GET',
          '/api/user_requests?properties[]=id&properties[]=status&properties[]=endAt',
        );
        $this->assertResponseIsSuccessful();
        $result = $response->toArray()['hydra:member'];
        $this->assertCount(6, $result);
    }

    public function testDemandsKpi(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request(
          'GET',
          '/api/user_requests/kpi',
        );
        $this->assertResponseIsSuccessful();
        $result = $response->toArray()['hydra:member'];
        $this->assertCount(1, $result);
        $this->assertSame(6, $result[0]['total']);
        $this->assertSame('1', $result[0]['expired']);
        $this->assertSame('1', $result[0]['twoDays']);
        $this->assertSame('2', $result[0]['tenDays']);
    }

    public function testAddUserRequest(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');

        $client->request('POST', '/api/user_requests', [
            'json' => [
                "endAt" => "18-04-2023",
                "motif" => $this->findIriBy(UserRequestMotif::class, ['name' => 'E-learning']),
                "typology" => $this->findIriBy(UserRequestTypology::class, ['name' => 'Simulation de retraite']),
                "channel" => $this->findIriBy(UserRequestChannel::class, ['name' => 'email']),
                "complaint" => false,
                "requestNote" => "Test",
                "handlingNote" => "Test",
                "responseType" => $this->findIriBy(UserRequestChannel::class, ['name' => 'email']),
                "profile" => $this->findIriBy(Profile::class, ['registrationNumber' => '010101']),
                "status" => "in_progress",
                "createdBy" => $this->findIriBy(Profile::class, ['registrationNumber' => '010101']),
            ]]);

        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdateUserRequest(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $userRequest = $this->findIriBy(UserRequest::class, ['number' => '666']);
        $client->request('PATCH', $userRequest, [
            'json' => [
                "endAt" => "18-04-2023",
                "motif" => $this->findIriBy(UserRequestMotif::class, ['name' => 'Demande de rendez-vous']),
                "typology" => $this->findIriBy(UserRequestTypology::class, ['name' => 'Bilan retraite']),
                "channel" => $this->findIriBy(UserRequestChannel::class, ['name' => 'internet']),
                "complaint" => false,
                "requestNote" => "Test",
                "handlingNote" => "Test",
                "responseType" => $this->findIriBy(UserRequestChannel::class, ['name' => 'internet']),
                "profile" => $this->findIriBy(Profile::class, ['registrationNumber' => '010101']),
                "status" => "in_progress",
                "createdBy" => $this->findIriBy(Profile::class, ['registrationNumber' => '010101']),
            ]]);
        $this->assertResponseStatusCodeSame(415);
    }

    public function testAssertCollectionFilter(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request(
            'GET',
            '/api/user_requests?motif.code=2&properties[]=id&properties[]=status&properties[]=endAt',
        );
        $this->assertResponseIsSuccessful();
        $result = $response->toArray()['hydra:member'];
        $this->assertCount(6, $result);
    }

    /**
     * @return void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @group only
     */
    public function testAssertCollectionFilterByProfile(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request(
            'GET',
            '/api/user_requests?profile.id=7'
            .'&properties[]=id&properties[]=status&properties[]=endAt&properties[]=number',
        );
        $this->assertResponseIsSuccessful();
        $result = $response->toArray()['hydra:member'];
        $this->assertCount(1, $result);
        $this->assertEquals(1, $result[0]['id']);
        $this->assertEquals('111', $result[0]['number']);
        $this->assertEquals('in_progress', $result[0]['status']);
    }

    public function testAssertCollectionAutocompleteByName(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request(
            'GET',
            '/api/user_requests?searchname=corine',
        );
        $this->assertResponseIsSuccessful();
        $result = $response->toArray()['hydra:member'];
        $this->assertCount(1, $result);
    }

    public function testAssertCollectionAutocompleteByEmail(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request(
            'GET',
            '/api/user_requests?searchemail=von.chyna@fadel.biz',
        );
        $this->assertResponseIsSuccessful();
        $result = $response->toArray()['hydra:member'];
        $this->assertCount(1, $result);
    }
}
