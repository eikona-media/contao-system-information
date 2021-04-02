<?php

declare(strict_types=1);

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
use Linfo\OS\OS;

/**
 * Class SystemLoadInfo.
 */
class SystemLoadInfo
{
    /**
     * @var float
     */
    private $last1Minute;

    /**
     * @var float
     */
    private $last5Minutes;

    /**
     * @var float
     */
    private $last15Minutes;

    /**
     * @var int
     */
    private $factor;

    public function init(): self
    {
        try {
            $linfo = new Linfo();
            /** @var OS $parser */
            $parser = $linfo->getParser();
            $cpu = $parser->getCPU();
            $load = $parser->getLoad();

            $this->setLast1Minute((float) ($load['now'] ?? 0));
            $this->setLast5Minutes((float) ($load['5min'] ?? 0));
            $this->setLast15Minutes((float) ($load['15min'] ?? 0));
            $this->setFactor(\count($cpu));
        } catch (FatalException $e) {
            $loadAvg = sys_getloadavg();

            $this->setLast1Minute((float) $loadAvg[0]);
            $this->setLast5Minutes((float) $loadAvg[1]);
            $this->setLast15Minutes((float) $loadAvg[2]);
            $this->setFactor(4);
        }

        return $this;
    }

    public function getLast1Minute(): float
    {
        return $this->last1Minute;
    }

    public function setLast1Minute(float $last1Minute): void
    {
        $this->last1Minute = $last1Minute;
    }

    public function getLast5Minutes(): float
    {
        return $this->last5Minutes;
    }

    public function setLast5Minutes(float $last5Minutes): void
    {
        $this->last5Minutes = $last5Minutes;
    }

    public function getLast15Minutes(): float
    {
        return $this->last15Minutes;
    }

    public function setLast15Minutes(float $last15Minutes): void
    {
        $this->last15Minutes = $last15Minutes;
    }

    public function getFactor(): int
    {
        return $this->factor;
    }

    public function setFactor(int $factor): void
    {
        $this->factor = $factor;
    }
}
