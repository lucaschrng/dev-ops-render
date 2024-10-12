<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200707174149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique index on the slug column of the question table';
    }

    public function up(Schema $schema): void
    {
        // Ajoute un index unique sur la colonne 'slug' de la table 'question'
        $table = $schema->getTable('question');
        $table->addUniqueIndex(['slug'], 'UNIQ_B6F7494E989D9B62');
    }

    public function down(Schema $schema): void
    {
        // Supprime l'index unique de la colonne 'slug'
        $table = $schema->getTable('question');
        $table->dropIndex('UNIQ_B6F7494E989D9B62');
    }
}
