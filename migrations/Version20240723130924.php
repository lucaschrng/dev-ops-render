<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240723130924 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'Data migration using grouped inserts for the answer table.';
	}

	public function up(Schema $schema): void
	{
		// Préparation des données à insérer
		$data = [
			[
				'content' => 'Lorem ipsum dolor sit amet...',
				'username' => 'John Doe',
				'votes' => 100,
				'created_at' => '2021-01-01 10:00:00',
				'updated_at' => '2021-01-01 10:00:00',
				'question_id' => 1
			],
			[
				'content' => 'Consectetur adipiscing elit...',
				'username' => 'Jane Smith',
				'votes' => 200,
				'created_at' => '2021-01-02 11:00:00',
				'updated_at' => '2021-01-02 11:00:00',
				'question_id' => 2
			],
			[
				'content' => 'Sed do eiusmod tempor incididunt...',
				'username' => 'Alice Johnson',
				'votes' => 300,
				'created_at' => '2021-01-03 12:00:00',
				'updated_at' => '2021-01-03 12:00:00',
				'question_id' => 3
			],
			[
				'content' => 'Ut labore et dolore magna aliqua...',
				'username' => 'Bob Brown',
				'votes' => 400,
				'created_at' => '2021-01-04 13:00:00',
				'updated_at' => '2021-01-04 13:00:00',
				'question_id' => 4
			],
			[
				'content' => 'Ut enim ad minim veniam...',
				'username' => 'Charlie White',
				'votes' => 500,
				'created_at' => '2021-01-05 14:00:00',
				'updated_at' => '2021-01-05 14:00:00',
				'question_id' => 5
			]
		];

		// Insérer les données dans des boucles de 5 éléments
		for ($i = 0; $i < 20; $i++) {
			foreach ($data as $index => $row) {
				$row['id'] = ($i * 5) + ($index + 1); // Calcul de l'ID
				$this->connection->insert('answer', $row);
			}
		}
	}

	public function down(Schema $schema): void
	{
		// Suppression des 100 premières lignes ajoutées dans 'answer'
		$this->connection->executeStatement('DELETE FROM answer WHERE id BETWEEN 1 AND 100');
	}
}
