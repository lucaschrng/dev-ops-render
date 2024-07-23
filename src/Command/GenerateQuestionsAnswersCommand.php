<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Question;
use App\Entity\Answer;
use App\Model\AnswerModel;
use App\Model\QuestionModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;
use DateTime;


final class GenerateQuestionsAnswersCommand extends Command
{
	protected static $defaultName = 'app:generate-questions-answers';
	private const ARR_QUESTIONS = [
		'color' => ['Question about color','What is your favorite color?', '2021-10-07 10:30:35', '2011-07-07 12:30:35'],
		'animal' => ['Question about animal','What is your favorite animal?', '2020-05-14 22:30:35', '2012-07-07 8:30:35'],
		'food' => ['Question about food','What is your favorite food?', '2018-05-12 22:30:35', '2022-07-07 22:30:35'],
	];

	private const ARR_ANSWERS = [
		'color' => [
			['donbrico', 'My favorite color is blue'],
			['attita', 'My less favorite color is green'],
			['attito', 'My almost best favorite color is red'],
		],
		'animal' => [
			['donbrico', 'My favorite animal is Dog'],
			['attita', 'My less favorite animal is Dog'],
			['attito', 'My almost best animal color is Mouse'],
		],
		'food' => [
			['donbrico', 'My favorite food is Chees'],
			['attita', 'My less favorite food is Pizza'],
			['attito', 'My almost best food color is Burger'],
		],
	];

	private EntityManagerInterface $entityManager;
	private SluggerInterface $slugger;

	public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
	{
		parent::__construct();
		$this->entityManager = $entityManager;
		$this->slugger = $slugger;
	}

	protected function configure(): void
	{
		$this
			->setDescription('Generate Questions and Answers and persist them to the database');
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);

		foreach (self::ARR_QUESTIONS as $key => $questions) {
			$newQuestion = new Question();
			$questionModel = new QuestionModel($questions, $this->slugger);

			$newQuestion->setName($questionModel->getName());
			$newQuestion->setQuestion($questionModel->getQuestion());
			$newQuestion->setSlug($questionModel->getSlug());
			$newQuestion->setVotes($questionModel->getVote());
			$newQuestion->setCreatedAt(new DateTime('now'));
			$newQuestion->setUpdatedAt(new DateTime('now'));

			$this->entityManager->persist($newQuestion);

			// Choose a random number of answers (between 1 and 3) for each question
			$numAnswers = random_int(1, 3);
			$chosenAnswers = (array) array_rand(self::ARR_ANSWERS[$key], $numAnswers);

			foreach ($chosenAnswers as $answerIndex) {
				$newAnswer = new Answer();
				$answerModel = new AnswerModel(self::ARR_ANSWERS[$key][$answerIndex]);

				$newAnswer->setContent($answerModel->getContent());
				$newAnswer->setUsername($answerModel->getUsername());
				$newAnswer->setVotes($answerModel->getVote());
				$newAnswer->setCreatedAt(new DateTime('now'));
				$newAnswer->setUpdatedAt(new DateTime('now'));

				$newAnswer->setQuestion($newQuestion);

				$this->entityManager->persist($newAnswer);
			}
		}

		$this->entityManager->flush();

		$io->success('Questions and answers have been generated and persisted to the database.');

		return Command::SUCCESS;
	}
}
