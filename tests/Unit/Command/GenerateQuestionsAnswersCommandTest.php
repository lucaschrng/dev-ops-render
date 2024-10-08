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

class GenerateQuestionsAnswersCommandTest extends TestCase
{
    private EntityManagerInterface $entityManager; // Typage explicite
    private SluggerInterface $slugger; // Typage explicite
    private CommandTester $commandTester; // Déclaration de la propriété commandTester

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->slugger = $this->createMock(SluggerInterface::class);

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

        $this->assertSame('Question about color', $questionModel->getName());
        $this->assertSame('What is your favorite color?', $questionModel->getQuestion());
        $this->assertSame('mocked-slug', $questionModel->getSlug());
    }

    public function testExecuteCommand(): void
    {
        // Simulez les comportements nécessaires pour l'exécution de la commande
        // Par exemple, vous pourriez configurer des réponses de mock pour l'EntityManager ou le Slugger

        // Exécutez la commande
        $this->commandTester->execute([]);

        // Vérifiez la sortie de la commande
        $output = $this->commandTester->getDisplay();

        // Assurez-vous que la sortie contient ce que vous attendez
        $this->assertStringContainsString(
            'expected output',
            $output
        ); // Remplacez 'expected output' par ce que vous attendez
    }
}
