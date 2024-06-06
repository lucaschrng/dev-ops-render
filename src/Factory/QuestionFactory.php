<?php

namespace App\Factory;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @method static Question|Proxy findOrCreate(array $attributes)
 * @method static Question|Proxy random()
 * @method static Question[]|Proxy[] randomSet(int $number)
 * @method static Question[]|Proxy[] randomRange(int $min, int $max)
 * @method static QuestionRepository|RepositoryProxy repository()
 * @method Question|Proxy create($attributes = [])
 * @method Question[]|Proxy[] createMany(int $number, $attributes = [])
 */
final class QuestionFactory extends ModelFactory
{
    public function unpublished(): self
    {
        return $this->addState([
            'askedAt' => null,
        ]);
    }

    protected function getDefaults(): array
    {
        return [
            'slug' => self::faker()->slug(10, true),
            'name' => self::faker()->realText(50),
            'question' => self::faker()->paragraphs(
                self::faker()->numberBetween(1, 4),
                true
            ),
            'askedAt' => self::faker()->dateTimeBetween('-100 days', '-1 minute'),
            'votes' => random_int(-20, 50),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
   //->afterInstantiate(function(Question $question) { });
   ;
    }

    protected static function getClass(): string
    {
        return Question::class;
    }
}
