<?php

namespace App\Factory;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Question>
 *
 * @method        Question|Proxy                     create(array|callable $attributes = [])
 * @method static Question|Proxy                     createOne(array $attributes = [])
 * @method static Question|Proxy                     find(object|array|mixed $criteria)
 * @method static Question|Proxy                     findOrCreate(array $attributes)
 * @method static Question|Proxy                     first(string $sortedField = 'id')
 * @method static Question|Proxy                     last(string $sortedField = 'id')
 * @method static Question|Proxy                     random(array $attributes = [])
 * @method static Question|Proxy                     randomOrCreate(array $attributes = [])
 * @method static QuestionRepository|RepositoryProxy repository()
 * @method static Question[]|Proxy[]                 all()
 * @method static Question[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Question[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Question[]|Proxy[]                 findBy(array $attributes)
 * @method static Question[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Question[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Question> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Question> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Question> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Question> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Question> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Question> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Question> random(array $attributes = [])
 * @phpstan-method static Proxy<Question> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Question> repository()
 * @phpstan-method static list<Proxy<Question>> all()
 */
final class QuestionFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'askedAt' => self::faker()->dateTime(),
            'createdAt' => self::faker()->dateTime(),
            'name' => self::faker()->text(255),
            'slug' => self::faker()->text(255),
	        'updatedAt' => self::faker()->dateTime(),
	        'votes' => self::faker()->randomNumber(),
	        'question' => QuestionFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Question $question): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Question::class;
    }
}
