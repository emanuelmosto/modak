<?php

namespace Project\Entities;

final class Rate implements \JsonSerializable
{

    const MICROSECOND = "microsecond";
    const MILLISECOND = "millisecond";
    const SECOND = "second";
    const MINUTE = "minute";
    const HOUR = "hour";
    const DAY = "day";
    const WEEK = "week";
    const MONTH = "month";
    const YEAR = "year";

    /**
     * @var double[] Mapping between units and seconds
     */
    private static array $unitMap = [
        self::MICROSECOND => 0.000001,
        self::MILLISECOND => 0.001,
        self::SECOND => 1,
        self::MINUTE => 60,
        self::HOUR => 3600,
        self::DAY => 86400,
        self::WEEK => 604800,
        self::MONTH => 2629743.83,
        self::YEAR => 31556926,
    ];

    /**
     * @var int The amount of rates to produce for the unit.
     */
    private int $rate;

    /**
     * @var string The unit.
     */
    private string $unit;

    /**
     * @var string The Current Time.
     */
    private string $currentTime;

    /**
     * Sets the amount of rates which will be produced per unit.
     *
     * E.g. new Rate(100, Rate::SECOND) will produce 100 rates per second.
     *
     * @param int $rate
     * @param string $unit unit as one of Rate's constants
     * @param string $currentTime
     */
    public function __construct(int $rate, string $unit, string $currentTime)
    {
        if (!isset(self::$unitMap[$unit])) {
            throw new \InvalidArgumentException("Not a valid unit.");
        }
        if ($rate < 0) {
            throw new \InvalidArgumentException("Amount of rate should be greater then 0.");
        }
        $this->rate = $rate;
        $this->unit = $unit;
        $this->currentTime = $currentTime;
    }

    /**
     * Returns the rate in rates per second.
     *
     * @return float|int The rate.
     * @internal
     */
    public function getRatesPerSecond(): float|int
    {
        return $this->rate / self::$unitMap[$this->unit];
    }

    /**
     * Returns the rate in rates in second.
     *
     * @return float|int The rate.
     * @internal
     */
    public function getRatesInSecond(): float|int
    {
        return $this->rate * self::$unitMap[$this->unit];
    }

    /**
     * Returns the current Time
     *
     * @return float|int The rate.
     * @internal
     */
    public function getCurrentTime(): float|int
    {
        return $this->currentTime;
    }

    /**
     * Returns the rate
     *
     * @return int The rate.
     * @internal
     */
    public function getRateNumber(): int
    {
        return $this->rate;
    }

    /**
     * Update the rate
     *
     * @param $rate
     * @return void The rate.
     * @internal
     */
    public function updateRate($rate): void
    {
        $this->rate = $rate;
    }

    /**
     * Set the current Time
     *
     * @internal
     */
    public function updateCurrentTime($currentTime)
    {
        $this->currentTime = $currentTime;
    }


    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $toSerialize = new \stdClass();
        $toSerialize->rate = $this->rate;
        $toSerialize->unit = $this->unit;
        $toSerialize->currentTime = $this->currentTime;

        return $toSerialize;
    }
}
