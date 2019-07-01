<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilmSession
 *
 * @ORM\Table(name="film_session", uniqueConstraints={@ORM\UniqueConstraint(name="film_session_film_id_execute_date_idx", columns={"film_id", "execute_date"}), @ORM\UniqueConstraint(name="film_session_film_id_execute_date", columns={"film_id", "execute_date"})}, indexes={@ORM\Index(name="film_session_execute_date", columns={"execute_date"})})
 * @ORM\Entity(repositoryClass="App\Repository\FilmSessionRepository")
 */
class FilmSession
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="film_session_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="film_id", type="integer", nullable=false)
     */
    private $filmId;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="execute_date", type="datetimetz", nullable=false)
     */
    private $executeDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilmId(): ?int
    {
        return $this->filmId;
    }

    public function setFilmId(?int $filmId): self
    {
        $this->filmId = $filmId;

        return $this;
    }

    public function getExecuteDate(): ?\DateTimeInterface
    {
        return $this->executeDate;
    }

    public function setExecuteDate(?\DateTimeInterface $executeDate): self
    {
        $this->executeDate = $executeDate;

        return $this;
    }
}
