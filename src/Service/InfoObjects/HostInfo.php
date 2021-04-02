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
 * Class HostInfo.
 */
class HostInfo
{
    /**
     * @var string
     */
    private $hostname;

    /**
     * @var string
     */
    private $accessedIP;

    /**
     * @var string
     */
    private $uptime;

    public function init(): self
    {
        try {
            $linfo = new Linfo();
            /** @var OS $parser */
            $parser = $linfo->getParser();
            $hostname = $parser->getHostName();
            $accessedIP = $parser->getAccessedIP();
            $uptime = $parser->getUpTime();

            // collect host information
            $this->setHostname($hostname);
            $this->setAccessedIP($accessedIP);
            $this->setUptime($uptime['text'] ?? '');
        } catch (FatalException $e) {
            $host = gethostname();
            $ip = gethostbyname($host);

            // collect host information
            $this->setHostname($host);
            $this->setAccessedIP($ip);
            $this->setUptime('-');
        }

        return $this;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    public function getAccessedIP(): string
    {
        return $this->accessedIP;
    }

    public function setAccessedIP(string $accessedIP): void
    {
        $this->accessedIP = $accessedIP;
    }

    public function getUptime(): string
    {
        return $this->uptime;
    }

    public function setUptime(string $uptime): void
    {
        $this->uptime = $uptime;
    }
}
