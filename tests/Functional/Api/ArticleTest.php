<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Category;
use App\Tests\EntityManagerTrait;

final class ArticleTest extends ApiTestCase
{
    use AuthenticatedClientTrait, EntityManagerTrait;

    private const NB_TOTAL_ARTICLES = 5;
    public function testAssertCollectionArticlesByProfile(): void
    {
        $client = static::createAuthenticatedClient('superadmin@s2h.corp');
        $response = $client->request('GET', '/api/articles');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        //assert number of items
        $this->assertCount(self::NB_TOTAL_ARTICLES, $response->toArray()['hydra:member']);

        $client = static::createAuthenticatedClient('user@s2h.corp');
        $response = $client->request('GET', '/api/articles');

        $this->assertSame(self::NB_TOTAL_ARTICLES, $response->toArray()['hydra:totalItems']);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * @dataProvider articlesProvider
     */
    public function testAssertCollectionArticlesWithSearchFilterIterator(array $search): void
    {
        $client = static::createAuthenticatedClient('user@s2h.corp');
        $category = null;
        if (!empty($search['category'])) {
            $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $search['category']]);
        }

        $params = [
            'title' => $search['title'] ?? '',
            'categories.id' => $category ? $category->getId() : ''
        ];
        $response = $client->request('GET', '/api/articles?' . http_build_query($params));
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSame($search['expectedTotalItems'], $response->toArray()['hydra:totalItems']);
    }

    public function articlesProvider(): iterable
    {
        yield 'une recherche sans resultat' => [
            [
                'title' => 'une recherche sans resultat',
                'category' => '',
                'expectedTotalItems' => 0
            ]
        ];

        yield 'une recherche sur le bilan seul' => [
            [
                'title' => 'Un article sur le theme de',
                'category' => '',
                'expectedTotalItems' => 2
            ]
        ];

        yield 'une recherche  sur le bilan + category bilan' => [
            [
                'title' => 'Un article sur le theme de',
                'category' => 'bilan',
                'expectedTotalItems' => 1
            ]
        ];

        yield 'une recherche  sur category bilan' => [
            [
                'title' => '',
                'category' => 'bilan',
                'expectedTotalItems' => 2
            ]
        ];

        yield 'une recherche  sur category retraite' => [
            [
                'title' => '',
                'category' => 'retraite',
                'expectedTotalItems' => 3
            ]
        ];
    }


}
