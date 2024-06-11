<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\UserFixtures;

final class UsersAuthenticationTest extends ApiTestCase
{
    use AuthenticatedClientTrait;
    /**
     * @dataProvider provideGoodLoginUser
     */
    public function testSuccessfullLoginUser(array $data): void
    {
        $client = self::createClient();
        $response = $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data,
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();

        $this->assertArrayHasKey('token', $json);
        $this->assertArrayHasKey('refresh_token', $json);
        //test get companies
        $client->request('GET', '/api/companies');
        $this->assertResponseStatusCodeSame(401);

        $client->request('GET', '/api/companies', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();
    }


    public function provideGoodLoginUser(): iterable
    {
        $defaultData = static fn(array $data) => array_merge([
            'username' => '',
            'password' => AuthenticatedClientTrait::getDefaultPassword(),
        ], $data);

        yield 'Default Supper admin' => [$defaultData(['username' => 'superadmin@s2h.corp'])];
        yield 'Default Manager' => [$defaultData(['username' => 'admin@s2h.corp'])];
        yield 'Default Gestionnaire' => [$defaultData(['username' => 'gestionnaire@s2h.corp'])];
        yield 'Default User' => [$defaultData(['username' => 'user@s2h.corp'])];
    }


    /**
     * @dataProvider provideBadLoginUser
     */
    public function testFailedLoginUser(array $data): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $data,
        ]);
        $this->assertResponseStatusCodeSame(401);
    }

    public function provideBadLoginUser(): iterable
    {
        $defaultData = static fn(array $data) => array_merge([
            'username' => '',
            'password' => AuthenticatedClientTrait::getDefaultPassword(),
        ], $data);

        yield 'Bad username' => [$defaultData(['username' => 'su@s2h.corp'])];
        yield 'Empty username' => [$defaultData(['username' => 'faile'])];
        yield 'Bad password' => [$defaultData(['password' => 'failed'])];
        yield 'Empty password' => [$defaultData(['password' => ''])];
    }
}
