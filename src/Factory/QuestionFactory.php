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
 * @phpstan-method static Question&Proxy<Question> find(object|array|mixed $criteria)
 * @phpstan-method static Question&Proxy<Question> findOrCreate(array $attributes)
 * @phpstan-method static Question&Proxy<Question> first(string $sortedField = 'id')
 * @phpstan-method static Question&Proxy<Question> last(string $sortedField = 'id')
 * @phpstan-method static Question&Proxy<Question> random(array $attributes = [])
 * @phpstan-method static Question&Proxy<Question> randomOrCreate(array $attributes = [])
 * @phpstan-method static ProxyRepositoryDecorator<Question, EntityRepository> repository()
 * @phpstan-method static list<Question&Proxy<Question>> all()
 * @phpstan-method static list<Question&Proxy<Question>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Question&Proxy<Question>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Question&Proxy<Question>> findBy(array $attributes)
 * @phpstan-method static list<Question&Proxy<Question>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Question&Proxy<Question>> randomSet(int $number, array $attributes = [])
 */
final class QuestionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Question::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => self::faker()->dateTime(),
            'name' => self::faker()->text(255),
            'question' => self::faker()->text(),
            'slug' => self::faker()->text(255),
            'updatedAt' => self::faker()->dateTime(),
            'votes' => self::faker()->randomNumber(),
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
