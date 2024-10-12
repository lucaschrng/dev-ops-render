<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200708195925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add votes column to question table with default value';
    }

    public function up(Schema $schema): void
    {
        // Récupère la table 'question'
        $table = $schema->getTable('question');

        // Ajoute une colonne 'votes' avec un type 'integer' et une valeur par défaut de 0
        $table->addColumn('votes', 'integer', [
            'notnull' => true,
            'default' => 0
        ]);
    }

    public function down(Schema $schema): void
    {
        // Récupère la table 'question' et supprime la colonne 'votes'
        $table = $schema->getTable('question');
        $table->dropColumn('votes');
    }
}
