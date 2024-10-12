<?php

namespace App\Factory;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Question>
 *
 * @method        Question|Proxy                              create(array|callable $attributes = [])
 * @method static Question|Proxy                              createOne(array $attributes = [])
 * @method static Question|Proxy                              find(object|array|mixed $criteria)
 * @method static Question|Proxy                              findOrCreate(array $attributes)
 * @method static Question|Proxy                              first(string $sortedField = 'id')
 * @method static Question|Proxy                              last(string $sortedField = 'id')
 * @method static Question|Proxy                              random(array $attributes = [])
 * @method static Question|Proxy                              randomOrCreate(array $attributes = [])
 * @method static QuestionRepository|ProxyRepositoryDecorator repository()
 * @method static Question[]|Proxy[]                          all()
 * @method static Question[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Question[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Question[]|Proxy[]                          findBy(array $attributes)
 * @method static Question[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Question[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Question&Proxy<Question> create(array|callable $attributes = [])
 * @phpstan-method static Question&Proxy<Question> createOne(array $attributes = [])
 * @phpstan-method static ProxyRepositoryDecorator<Question, EntityRepository> repository()
 * @phpstan-method static list<Question&Proxy<Question>> all()
 */
final class QuestionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Question::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => self::faker()->dateTimeBetween('-1 year'),
            'updatedAt' => self::faker()->dateTime(),
            'name' => self::faker()->realText(50),
            'question' => self::faker()->text(),
            'askedAt' => self::faker()->dateTimeBetween('-100 days', '-1 minute'),
            'votes' => random_int(-20, 50),
            'slug' => self::faker()->slug(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Question $question): void {})
        ;
    }
}
