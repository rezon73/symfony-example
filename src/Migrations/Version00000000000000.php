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
  id serial NOT NULL,
  name character(256) NOT NULL,
  CONSTRAINT film_id PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
        ');

        $this->addSql('
CREATE TABLE public.film_session
(
  id serial NOT NULL,
  film_id integer NOT NULL,
  execute_date timestamp(0) with time zone NOT NULL,
  CONSTRAINT film_session_id PRIMARY KEY (id),
  CONSTRAINT film_session_film_id_execute_date UNIQUE (film_id, execute_date)
)
WITH (
  OIDS=FALSE
);
        ');

        $this->addSql('ALTER TABLE public.film OWNER TO postgres;');
        $this->addSql('ALTER TABLE public.film_session OWNER TO postgres;');

        $this->addSql('
CREATE INDEX film_session_execute_date
  ON public.film_session
  USING btree
  (execute_date);
        ');
        $this->addSql('
CREATE UNIQUE INDEX film_session_film_id_execute_date_idx
  ON public.film_session
  USING btree
  (film_id, execute_date);
        ');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('
DROP TABLE public.film;
DROP INDEX public.film_session_execute_date;
DROP INDEX public.film_session_film_id_execute_date_idx;
DROP TABLE public.film_session;
        ');
    }
}
