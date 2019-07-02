<?php

namespace App\Entity;

/**
 * Class FilmSessionFilter
 * @package App\Entity
 */
class FilmSessionFilter
{
    public const VALIDATE_SUCCESS              = 0;
    public const VALIDATE_ERROR_INVERTED_DATES = 1;
    public const VALIDATE_ERROR_NULLED_DATES   = 2;

    /**
     * @var \DateTimeInterface
     */
    protected $fromDate;

    /**
     * @var \DateTimeInterface
     */
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

    public function validate()
    {
        if (
            is_null($this->getFromDate())
            || is_null($this->getToDate())
        ) {
            return static::VALIDATE_ERROR_NULLED_DATES;
        }

        if (
            $this->getFromDate()->diff(
                $this->getToDate()
            )->invert == 1
        ) {
            return static::VALIDATE_ERROR_INVERTED_DATES;
        }

        return static::VALIDATE_SUCCESS;
    }
}