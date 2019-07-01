<?php

namespace App\Entity;

/**
 * Class FilmSessionFilter
 * @package App\Entity
 */
class FilmSessionFilter
{
    protected $fromDate;

    protected $toDate;

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function fromDate(?\DateTimeInterface $startDate): self
    {
        $this->fromDate = $startDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(?\DateTimeInterface $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }
}