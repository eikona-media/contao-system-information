<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Service\InfoObjects;

use Linfo\Linfo;

/**
 * Class HostInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class HostInfo
{
    /**
     * @var string $hostname
     */
    private $hostname;

    /**
     * @var string $accessedIP
     */
    private $accessedIP;

    /**
     * @var string $uptime
     */
    private $uptime;

    /**
     * HostInfo constructor.
     */
    public function __construct()
    {
        $linfo = new Linfo();
        $parser = $linfo->getParser();
        $hostname = $parser->getHostName();
        $accessedIP = $parser->getAccessedIP();
        $uptime = $parser->getUpTime();

        // collect host information
        $this->setHostname($hostname);
        $this->setAccessedIP($accessedIP);
        $this->setUptime($uptime['text'] ?? '');
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    /**
     * @return string
     */
    public function getAccessedIP(): string
    {
        return $this->accessedIP;
    }

    /**
     * @param string $accessedIP
     */
    public function setAccessedIP(string $accessedIP): void
    {
        $this->accessedIP = $accessedIP;
    }

    /**
     * @return string
     */
    public function getUptime(): string
    {
        return $this->uptime;
    }

    /**
     * @param string $uptime
     */
    public function setUptime(string $uptime): void
    {
        $this->uptime = $uptime;
    }
}
