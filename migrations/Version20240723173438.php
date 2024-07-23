<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240723173438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Generated DATA from existing DATA in database, ' . 
        'Alert ! this script will truncate all tables before beginning';
    }
    
    public function preUp(Schema $schema): void
    {
        // Important to truncate table before adding duplicate values
        $this->addSql("SET foreign_key_checks = 0");
        $this->addSql("TRUNCATE TABLE `question`");
        $this->addSql("TRUNCATE TABLE `answer`");
        $this->addSql("SET foreign_key_checks = 1");
        
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
	    $this->addSql("SET foreign_key_checks = 0");
        $this->addSql("INSERT INTO question (id, name, slug, question, asked_at, votes, created_at, updated_at) VALUES (1, 'I say--that\'s the same size: to be treated with.', 'modi-molestias-consequatur-tenetur-tempora-quia', 'Id sint qui quibusdam aut aspernatur dolorum voluptatem. Sit et corrupti voluptatem esse nobis cupiditate. Sit voluptas ducimus cumque incidunt voluptatem quisquam.', '2024-06-05 05:03:54', -7, '2023-12-11 05:40:40', '2021-12-09 15:47:54')");
        $this->addSql("INSERT INTO question (id, name, slug, question, asked_at, votes, created_at, updated_at) VALUES (2, 'Alice, \'to pretend to be almost out of that is.', 'excepturi-commodi-sint-ut-alias-ipsum-nihil', 'Adipisci cumque dolor ut dolores dolor provident veritatis ut. Asperiores dolores eveniet praesentium facilis saepe. Vero alias aspernatur temporibus.', '2024-05-22 09:02:32', -14, '2023-09-23 14:19:02', '2000-11-02 15:08:23')");
        $this->addSql("INSERT INTO question (id, name, slug, question, asked_at, votes, created_at, updated_at) VALUES (3, 'CHAPTER X. The Lobster Quadrille is!\' \'No.', 'magnam-voluptas-dolor-molestias-velit-nemo', 'Explicabo repellendus perspiciatis dicta qui qui. Voluptate blanditiis quia praesentium magnam. Eos tempora reprehenderit totam ut id. Qui sed occaecati ut rerum.', '2024-04-28 20:15:50', -4, '2024-03-05 23:31:59', '1970-06-03 00:13:35')");
        $this->addSql("INSERT INTO question (id, name, slug, question, asked_at, votes, created_at, updated_at) VALUES (4, 'Alice looked all round the thistle again; then.', 'sint-et-et-qui-ut-laboriosam-sint-rem', 'Ab saepe sit dolor ullam magnam accusamus. Praesentium occaecati fugit maiores. Quae vero quaerat odio deserunt perferendis. Omnis natus officia qui delectus at tempore ut.', '2024-05-12 23:52:10', 9, '2024-03-09 03:15:12', '2014-01-09 14:04:53')");
        $this->addSql("INSERT INTO question (id, name, slug, question, asked_at, votes, created_at, updated_at) VALUES (5, 'This is the same age as herself, to see if she.', 'voluptatem-exercitationem-nemo-aut-exercitationem-qui-aspernatur', 'Debitis sit aperiam eligendi repellat amet et. Accusamus commodi ex molestias quos omnis tempore quae. Eum natus et ex eligendi ut.', '2024-07-13 11:54:39', 19, '2023-11-28 19:00:32', '1993-01-07 22:53:57')");
        $this->addSql("INSERT INTO answer (id, question_id, content, username, votes, created_at, updated_at) VALUES (1, 1, 'Ab neque nostrum et explicabo. Ad sit eligendi nemo sed omnis consequatur soluta reprehenderit. Eveniet nisi reiciendis perferendis culpa nihil.', 'lwaelchi', 43, '2024-01-18 18:48:17', '2024-06-25 12:01:46')");
        $this->addSql("INSERT INTO answer (id, question_id, content, username, votes, created_at, updated_at) VALUES (2, 2, 'Officia nemo qui neque repudiandae dolores tempora. Libero et animi perferendis tempora consequatur sunt accusamus.', 'loy.kemmer', -11, '2024-06-29 11:52:09', '1983-11-15 20:13:30')");
        $this->addSql("INSERT INTO answer (id, question_id, content, username, votes, created_at, updated_at) VALUES (3, 5, 'Vel cum ducimus est neque. Nam unde et qui sed. Animi sed enim nobis. Ipsam sit id ipsam iure ut.', 'ubotsford', -14, '2024-01-28 17:38:28', '1994-10-18 21:11:05')");
	    $this->addSql("SET foreign_key_checks = 1");
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}