<?php

namespace App\DataFixtures;

use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        QuestionFactory::createMany(5);

		AnswerFactory::createMany(3, static function() {
			return [
				'question' => QuestionFactory::random(),
			];
		});

		$manager->flush();
    }
}
