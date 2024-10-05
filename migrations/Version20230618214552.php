<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230618214552 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'Create the answer table';
	}

	public function up(Schema $schema): void
	{
		// Création de la table 'answer' de manière agnostique
		$table = $schema->createTable('answer');

		// Ajout de la colonne 'id' en tant qu'auto-incrément
		$table->addColumn('id', 'integer', [
			'autoincrement' => true
		]);

		// Ajout des autres colonnes
		$table->addColumn('content', 'text', [
			'notnull' => true
		]);
		$table->addColumn('username', 'string', [
			'length' => 255,
			'notnull' => true
		]);
		$table->addColumn('votes', 'integer', [
			'notnull' => true
		]);
		$table->addColumn('created_at', 'datetime', [
			'notnull' => true
		]);
		$table->addColumn('updated_at', 'datetime', [
			'notnull' => true
		]);

		// Définir la clé primaire
		$table->setPrimaryKey(['id']);
	}

	public function down(Schema $schema): void
	{
		// Suppression de la table 'answer'
		$schema->dropTable('answer');
	}
}
