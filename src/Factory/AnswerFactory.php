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
 * @phpstan-method static ProxyRepositoryDecorator<Answer, EntityRepository> repository()
 * @phpstan-method static list<Answer&Proxy<Answer>> all()

 */
final class AnswerFactory extends PersistentProxyObjectFactory
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
        return Answer::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     *
     */
    protected function defaults(): array|callable
    {
        return [
            'content' => self::faker()->text(),
            'username' => self::faker()->userName(),
            'createdAt' => self::faker()->dateTimeBetween('-1 year'),
            'updatedAt' => self::faker()->dateTime(),
            'votes' => random_int(-20, 50),
            'question' => QuestionFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): AnswerFactory
    {
        return $this
            // ->afterInstantiate(function(Answer $answer): void {})
        ;
    }
}
