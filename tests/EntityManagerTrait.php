<?php

declare(strict_types=1);

namespace App\Tests;

trait EntityManagerTrait
{
    protected $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
