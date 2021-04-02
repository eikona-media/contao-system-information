<?php

declare(strict_types=1);

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Service;

use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\DatabaseInfo;
use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\HardwareInfo;
use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\HostInfo;
use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\OSInfo;
use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\PHPInfo;
use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\SystemLoadInfo;
use EikonaMedia\Contao\SystemInformation\Service\InfoObjects\VirtualizationInfo;

/**
 * Class SystemInformationService.
 */
class SystemInformationService
{
    /**
     * @var SystemLoadInfo
     */
    private $systemLoadInfo;
    /**
     * @var HostInfo
     */
    private $hostInfo;
    /**
     * @var DatabaseInfo
     */
    private $databaseInfo;
    /**
     * @var PHPInfo
     */
    private $PHPInfo;
    /**
     * @var OSInfo
     */
    private $OSInfo;
    /**
     * @var HardwareInfo
     */
    private $hardwareInfo;
    /**
     * @var VirtualizationInfo
     */
    private $virtualizationInfo;

    public function __construct(SystemLoadInfo $systemLoadInfo, HostInfo $hostInfo, DatabaseInfo $databaseInfo, PHPInfo $PHPInfo, OSInfo $OSInfo, HardwareInfo $hardwareInfo, VirtualizationInfo $virtualizationInfo)
    {
        $this->systemLoadInfo = $systemLoadInfo;
        $this->hostInfo = $hostInfo;
        $this->databaseInfo = $databaseInfo;
        $this->PHPInfo = $PHPInfo;
        $this->OSInfo = $OSInfo;
        $this->hardwareInfo = $hardwareInfo;
        $this->virtualizationInfo = $virtualizationInfo;
    }

    public function getSystemLoadInfo(): SystemLoadInfo
    {
        return $this->systemLoadInfo->init();
    }

    public function getHostInfo(): HostInfo
    {
        return $this->hostInfo->init();
    }

    public function getDatabaseInfo(): DatabaseInfo
    {
        return $this->databaseInfo->init();
    }

    public function getPHPInfo(): PHPInfo
    {
        return $this->PHPInfo->init();
    }

    public function getOSInfo(): OSInfo
    {
        return $this->OSInfo->init();
    }

    public function getHardwareInfo(): HardwareInfo
    {
        return $this->hardwareInfo->init();
    }

    public function getVirtualizationInfo(): VirtualizationInfo
    {
        return $this->virtualizationInfo->init();
    }
}
