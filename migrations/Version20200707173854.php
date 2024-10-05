<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200707173854 extends AbstractMigration
{
	public function getDescription() : string
	{
		return 'Create the question table';
	}

	public function up(Schema $schema) : void
	{
		// Créer la table "question" de manière agnostique
		$table = $schema->createTable('question');

		// Colonne ID auto-incrémentée
		$table->addColumn('id', 'integer', [
			'autoincrement' => true
		]);

		// Colonne "name"
		$table->addColumn('name', 'string', [
			'length' => 255
		]);

		// Colonne "slug"
		$table->addColumn('slug', 'string', [
			'length' => 100
		]);

		// Colonne "question"
		$table->addColumn('question', 'text');

		// Colonne "asked_at" (nullable)
		$table->addColumn('asked_at', 'datetime', [
			'notnull' => false
		]);

		// Définir la clé primaire
		$table->setPrimaryKey(['id']);
	}

	public function down(Schema $schema) : void
	{
		// Supprimer la table "question"
		$schema->dropTable('question');
	}
}
