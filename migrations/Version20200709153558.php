<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200709153558 extends AbstractMigration
{
	public function getDescription() : string
	{
		return 'Add two nullable fields: created_at and updated_at to the question table';
	}

	public function up(Schema $schema) : void
	{
		// Récupère la table 'question'
		$table = $schema->getTable('question');

		// Ajoute la colonne 'created_at' de type datetime qui peut être null
		$table->addColumn('created_at', 'datetime', [
			'notnull' => false
		]);

		// Ajoute la colonne 'updated_at' de type datetime qui peut être null
		$table->addColumn('updated_at', 'datetime', [
			'notnull' => false
		]);
	}

	public function down(Schema $schema) : void
	{
		// Récupère la table 'question' et supprime les colonnes 'created_at' et 'updated_at'
		$table = $schema->getTable('question');
		$table->dropColumn('created_at');
		$table->dropColumn('updated_at');
	}
}
