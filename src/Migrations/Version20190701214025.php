<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190701214025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
INSERT INTO public.film (name) VALUES
    (\'film1\'),
    (\'film2\'),
    (\'film3\'),
    (\'film4\')
        ');

        $this->addSql('
INSERT INTO public.film_session (film_id, execute_date) VALUES
    (1, now()),
    (1, now() + interval \'1 hour\'),
    (1, now() + interval \'2 hour\'),
    (2, now() + interval \'3 hour\'),
    (2, now() + interval \'4 hour\')
        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
