<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version00000000000000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
   
CREATE TABLE public.film
(
  id integer NOT NULL,
  name character(256) NOT NULL,
  CONSTRAINT film_id PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.film
  OWNER TO postgres;

CREATE TABLE public.film_session
(
  id integer NOT NULL,
  film_id integer,
  execute_date date,
  CONSTRAINT film_session_id PRIMARY KEY (id),
  CONSTRAINT film_id_execute_date UNIQUE (film_id, execute_date)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.film_session
  OWNER TO postgres;

        ');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('
DROP TABLE public.film;
DROP TABLE public.film_session;
        ');
    }
}
