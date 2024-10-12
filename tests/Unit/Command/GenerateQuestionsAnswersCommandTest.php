<?php

declare(strict_types=1);

namespace App\Tests\Unit\Command;

use App\Command\GenerateQuestionsAnswersCommand;
use App\Model\AnswerModel;
use App\Model\QuestionModel;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

// Import de la classe UnicodeString

class GenerateQuestionsAnswersCommandTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private SluggerInterface $slugger;
    private CommandTester $commandTester;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->slugger = $this->createMock(SluggerInterface::class);

        // Simuler la méthode slug pour qu'elle retourne un UnicodeString
        $this->slugger->method('slug')
            ->willReturn(new UnicodeString('mocked-slug'));

        $command = new GenerateQuestionsAnswersCommand($this->entityManager, $this->slugger);

        $application = new Application();
        $application->add($command);

        $this->commandTester = new CommandTester($command);
    }

    public function testQuestionModelInteraction(): void
    {
        $questionData = [
            'Question about color',
            'What is your favorite color?',
            '2021-10-07 10:30:35',
            '2011-07-07 12:30:35'
        ];
        $questionModel = new QuestionModel($questionData, $this->slugger);

        // Assertions pour vérifier le comportement attendu
        $this->assertSame('Question about color', $questionModel->getName());
        $this->assertSame('What is your favorite color?', $questionModel->getQuestion());
        $this->assertSame('mocked-slug', $questionModel->getSlug());
    }

    public function testExecuteCommand(): void
    {
        // Exécutez la commande
        $this->commandTester->execute([]);

        // Vérifiez la sortie de la commande
        $output = $this->commandTester->getDisplay();

        // Assurez-vous que la sortie contient ce que vous attendez
        $this->assertStringContainsString(
            'Questions and answers have been generated and persisted to the database.',
            $output
        );
    }
}
