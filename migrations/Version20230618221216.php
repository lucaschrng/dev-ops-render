<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230618221216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Build relationship between question and answer';
    }

    public function up(Schema $schema): void
    {
        // Récupère la table 'answer'
        $table = $schema->getTable('answer');

        // Ajoute la colonne 'question_id' pour la relation avec 'question'
        $table->addColumn('question_id', 'integer', [
            'notnull' => true
        ]);

        // Ajoute l'index sur la colonne 'question_id'
        $table->addIndex(['question_id'], 'IDX_DADD4A251E27F6BF');

        // Ajoute la contrainte de clé étrangère entre 'answer' et 'question'
        $table->addForeignKeyConstraint('question', ['question_id'], ['id'], [
            'onDelete' => 'CASCADE'
        ]);
    }

    public function down(Schema $schema): void
    {
        // Récupère la table 'answer'
        $table = $schema->getTable('answer');

        // Supprime la contrainte de clé étrangère
        $table->removeForeignKey('FK_DADD4A251E27F6BF');

        // Supprime l'index sur 'question_id'
        $table->dropIndex('IDX_DADD4A251E27F6BF');

        // Supprime la colonne 'question_id'
        $table->dropColumn('question_id');
    }
}
