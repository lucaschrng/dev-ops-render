<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\CommentController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentControllerTest extends TestCase
{
	/**
	 * @throws Exception
	 * @throws \JsonException
	 */
	public function testCommentVoteUp()
	{
		$logger = $this->createMock(LoggerInterface::class);
		$logger->expects($this->once())
			->method('info')
			->with('Voting up!');

		$controller = $this->getMockBuilder(CommentController::class)
			->disableOriginalConstructor()
			->onlyMethods(['json'])
			->getMock();

		$controller->method('json')
			->willReturnCallback(function ($data) {
				return new JsonResponse($data);
			});

		$response = $controller->commentVote(1, 'up', $logger);

		$this->assertInstanceOf(JsonResponse::class, $response);
		$data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
		$this->assertArrayHasKey('votes', $data);
		$this->assertGreaterThanOrEqual(7, $data['votes']);
		$this->assertLessThanOrEqual(100, $data['votes']);
	}

	public function testCommentVoteDown()
	{
		$logger = $this->createMock(LoggerInterface::class);
		$logger->expects($this->once())
			->method('info')
			->with('Voting down!');

		$controller = $this->getMockBuilder(CommentController::class)
			->disableOriginalConstructor()
			->onlyMethods(['json'])
			->getMock();

		$controller->method('json')
			->willReturnCallback(function ($data) {
				return new JsonResponse($data);
			});

		$response = $controller->commentVote(1, 'down', $logger);

		$this->assertInstanceOf(JsonResponse::class, $response);
		$data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
		$this->assertArrayHasKey('votes', $data);
		$this->assertGreaterThanOrEqual(0, $data['votes']);
		$this->assertLessThanOrEqual(5, $data['votes']);
	}
}
