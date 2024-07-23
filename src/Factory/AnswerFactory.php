<?php

namespace App\Factory;

use App\Entity\Answer;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Answer>
 *
 * @method        Answer|Proxy                              create(array|callable $attributes = [])
 * @method static Answer|Proxy                              createOne(array $attributes = [])
 * @method static Answer|Proxy                              find(object|array|mixed $criteria)
 * @method static Answer|Proxy                              findOrCreate(array $attributes)
 * @method static Answer|Proxy                              first(string $sortedField = 'id')
 * @method static Answer|Proxy                              last(string $sortedField = 'id')
 * @method static Answer|Proxy                              random(array $attributes = [])
 * @method static Answer|Proxy                              randomOrCreate(array $attributes = [])
 * @method static AnswerRepository|ProxyRepositoryDecorator repository()
 * @method static Answer[]|Proxy[]                          all()
 * @method static Answer[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Answer[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Answer[]|Proxy[]                          findBy(array $attributes)
 * @method static Answer[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Answer[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Answer&Proxy<Answer> create(array|callable $attributes = [])
 * @phpstan-method static Answer&Proxy<Answer> createOne(array $attributes = [])
 * @phpstan-method static Answer&Proxy<Answer> find(object|array|mixed $criteria)
 * @phpstan-method static Answer&Proxy<Answer> findOrCreate(array $attributes)
 * @phpstan-method static Answer&Proxy<Answer> first(string $sortedField = 'id')
 * @phpstan-method static Answer&Proxy<Answer> last(string $sortedField = 'id')
 * @phpstan-method static Answer&Proxy<Answer> random(array $attributes = [])
 * @phpstan-method static Answer&Proxy<Answer> randomOrCreate(array $attributes = [])
 * @phpstan-method static ProxyRepositoryDecorator<Answer, EntityRepository> repository()
 * @phpstan-method static list<Answer&Proxy<Answer>> all()
 * @phpstan-method static list<Answer&Proxy<Answer>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Answer&Proxy<Answer>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Answer&Proxy<Answer>> findBy(array $attributes)
 * @phpstan-method static list<Answer&Proxy<Answer>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Answer&Proxy<Answer>> randomSet(int $number, array $attributes = [])
 */
final class AnswerFactory extends PersistentProxyObjectFactory
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
        return Answer::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'content' => self::faker()->text(),
            'createdAt' => self::faker()->dateTime(),
            'question' => QuestionFactory::new(),
            'updatedAt' => self::faker()->dateTime(),
            'username' => self::faker()->text(255),
            'votes' => self::faker()->randomNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Answer $answer): void {})
        ;
    }
}
