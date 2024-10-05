<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230615135419 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'Modify votes, created_at, and updated_at columns in the question table';
	}

	public function up(Schema $schema): void
	{
		// Modifications simples sur les colonnes sans passer par setType
		$this->addSql('ALTER TABLE question ALTER votes SET DEFAULT 0');
		$this->addSql('ALTER TABLE question ALTER COLUMN created_at DROP DEFAULT');
		$this->addSql('ALTER TABLE question ALTER COLUMN updated_at DROP DEFAULT');
	}

	public function down(Schema $schema): void
	{
		// Revert les modifications
		$this->addSql('ALTER TABLE question ALTER votes SET DEFAULT 0');
		$this->addSql('ALTER TABLE question ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP');
		$this->addSql('ALTER TABLE question ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP');
	}
}
