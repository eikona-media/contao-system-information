<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Service\InfoObjects;

use Linfo\Exceptions\FatalException;
use Linfo\Linfo;

/**
 * Class SystemLoadInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class SystemLoadInfo
{
    /**
     * @var float $last1Minute
     */
    private $last1Minute;

    /**
     * @var float $last5Minutes
     */
    private $last5Minutes;

    /**
     * @var float $last15Minutes
     */
    private $last15Minutes;

    /**
     * @var int $factor
     */
    private $factor;

    /**
     * PHPInfo constructor.
     */
    public function __construct()
    {
        try {
            $linfo = new Linfo();
            $parser = $linfo->getParser();
            $cpu = $parser->getCPU();
            $load = $parser->getLoad();

            $this->setLast1Minute($load['now'] ?? 0);
            $this->setLast5Minutes($load['5min'] ?? 0);
            $this->setLast15Minutes($load['15min'] ?? 0);
            $this->setFactor(count($cpu));
        } catch (FatalException $e) {
            $loadAvg = sys_getloadavg();

            $this->setLast1Minute($loadAvg[0]);
            $this->setLast5Minutes($loadAvg[1]);
            $this->setLast15Minutes($loadAvg[2]);
            $this->setFactor(4);
        }
    }

    /**
     * @return float
     */
    public function getLast1Minute(): float
    {
        return $this->last1Minute;
    }

    /**
     * @param float $last1Minute
     */
    public function setLast1Minute(float $last1Minute): void
    {
        $this->last1Minute = $last1Minute;
    }

    /**
     * @return float
     */
    public function getLast5Minutes(): float
    {
        return $this->last5Minutes;
    }

    /**
     * @param float $last5Minutes
     */
    public function setLast5Minutes(float $last5Minutes): void
    {
        $this->last5Minutes = $last5Minutes;
    }

    /**
     * @return float
     */
    public function getLast15Minutes(): float
    {
        return $this->last15Minutes;
    }

    /**
     * @param float $last15Minutes
     */
    public function setLast15Minutes(float $last15Minutes): void
    {
        $this->last15Minutes = $last15Minutes;
    }

    /**
     * @return int
     */
    public function getFactor(): int
    {
        return $this->factor;
    }

    /**
     * @param int $factor
     */
    public function setFactor(int $factor): void
    {
        $this->factor = $factor;
    }
}
