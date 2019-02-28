<?php

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
 * Class SystemInformationService
 * @package EikonaMedia\Contao\SystemInformation\Service
 */
class SystemInformationService
{
    /**
     * @return SystemLoadInfo
     */
    public static function getSystemLoadInfo(): SystemLoadInfo
    {
        return new SystemLoadInfo();
    }

    /**
     * @return HostInfo
     */
    public static function getHostInfo(): HostInfo
    {
        return new HostInfo();
    }

    /**
     * @return DatabaseInfo
     */
    public static function getDatabaseInfo(): DatabaseInfo
    {
        return new DatabaseInfo();
    }

    /**
     * @return PHPInfo
     */
    public static function getPHPInfo(): PHPInfo
    {
        return new PHPInfo();
    }

    /**
     * @return OSInfo
     */
    public static function getOSInfo(): OSInfo
    {
        return new OSInfo();
    }

    /**
     * @return HardwareInfo
     */
    public static function getHardwareInfo(): HardwareInfo
    {
        return new HardwareInfo();
    }

    /**
     * @return VirtualizationInfo
     */
    public static function getVirtualizationInfo(): VirtualizationInfo
    {
        return new VirtualizationInfo();
    }
}
