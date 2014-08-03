<?php

namespace Brick\DateTime;

/**
 * Base class for Instant and ZonedDateTime.
 */
abstract class ReadableInstant
{
    /**
     * @return \Brick\DateTime\Instant
     */
    abstract public function getInstant();

    /**
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->getInstant()->getTimestamp();
    }

    /**
     * @return integer
     */
    public function getNanos()
    {
        return $this->getInstant()->getNanos();
    }

    /**
     * Compares this instant with another.
     *
     * Returns:
     *
     * * a negative number if this instant is before the given one;
     * * a positive number if this instant is after the given one;
     * * zero if this instant equals the given one.
     *
     * @param ReadableInstant $that
     *
     * @return integer
     */
    public function compareTo(ReadableInstant $that)
    {
        return $this->getInstant()->getTimestamp() - $that->getInstant()->getTimestamp();
    }

    /**
     * Returns whether this instant equals another.
     *
     * @param ReadableInstant $that
     *
     * @return boolean
     */
    public function isEqualTo(ReadableInstant $that)
    {
        return $this->compareTo($that) == 0;
    }

    /**
     * Returns whether this instant is after another.
     *
     * @param ReadableInstant $that
     *
     * @return boolean
     */
    public function isAfter(ReadableInstant $that)
    {
        return $this->compareTo($that) > 0;
    }

    /**
     * Returns whether this instant is after, or equal to, another.
     *
     * @param ReadableInstant $that
     *
     * @return boolean
     */
    public function isAfterOrEqualTo(ReadableInstant $that)
    {
        return $this->compareTo($that) >= 0;
    }

    /**
     * Returns whether this instant is before another.
     *
     * @param ReadableInstant $that
     *
     * @return boolean
     */
    public function isBefore(ReadableInstant $that)
    {
        return $this->compareTo($that) < 0;
    }

    /**
     * Returns whether this instant is before, or equal to, another.
     *
     * @param ReadableInstant $that
     *
     * @return boolean
     */
    public function isBeforeOrEqualTo(ReadableInstant $that)
    {
        return $this->compareTo($that) <= 0;
    }

    /**
     * Returns whether this instant is between the given instants, inclusive.
     *
     * @param ReadableInstant $first
     * @param ReadableInstant $last
     *
     * @return boolean
     */
    public function isBetweenInclusive(ReadableInstant $first, ReadableInstant $last)
    {
        return $this->isAfterOrEqualTo($first) && $this->isBeforeOrEqualTo($last);
    }

    /**
     * Returns whether this instant is between the given instants, exclusive.
     *
     * @param ReadableInstant $first
     * @param ReadableInstant $last
     *
     * @return boolean
     */
    public function isBetweenExclusive(ReadableInstant $first, ReadableInstant $last)
    {
        return $this->isAfter($first) && $this->isBefore($last);
    }

    /**
     * Returns whether this instant is in the past.
     *
     * @return boolean
     */
    public function isPast()
    {
        return $this->isBefore(Instant::now());
    }

    /**
     * Returns whether this instant is in the past or present.
     *
     * @return boolean
     */
    public function isPastOrPresent()
    {
        return $this->isBeforeOrEqualTo(Instant::now());
    }

    /**
     * Returns whether this instant is in the future.
     *
     * @return boolean
     */
    public function isFuture()
    {
        return $this->isAfter(Instant::now());
    }

    /**
     * Returns whether this instant is in the future or present.
     *
     * @return boolean
     */
    public function isFutureOrPresent()
    {
        return $this->isAfterOrEqualTo(Instant::now());
    }
}