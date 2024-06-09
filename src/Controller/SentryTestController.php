<?php

namespace App\Controller;

use LogicException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SentryTestController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route(name="sentry_test", path="/_sentry-test")
     */
    public function testLog(): void
    {
        // the following code will test if monolog integration logs to sentry
        $this->logger->error('My custom logged error.', [
            'some' => 'Context Data',
        ]);

        // the following code will test if an uncaught exception logs to sentry
        throw new LogicException('Example exception.');
    }
}
