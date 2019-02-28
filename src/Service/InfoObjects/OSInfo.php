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
 * Class OSInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class OSInfo
{
    /**
     * @var string $os
     */
    private $os;

    /**
     * @var string $distroName
     */
    private $distroName;

    /**
     * @var string $distroVersion
     */
    private $distroVersion;

    /**
     * @var string $kernel
     */
    private $kernel;

    /**
     * OSInfo constructor.
     */
    public function __construct()
    {
        $linfo = new Linfo();
        $parser = $linfo->getParser();
        $os = $parser->getOS();
        $distro = $parser->getDistro();
        $kernel = $parser->getKernel();

        $this->setOs($os);
        $this->setDistroName($distro['name'] ?? '');
        $this->setDistroVersion($distro['version'] ?? '');
        $this->setKernel($kernel);
    }

    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * @param string $os
     */
    public function setOs(string $os): void
    {
        $this->os = $os;
    }

    /**
     * @return string
     */
    public function getDistroName(): string
    {
        return $this->distroName;
    }

    /**
     * @param string $distroName
     */
    public function setDistroName(string $distroName): void
    {
        $this->distroName = $distroName;
    }

    /**
     * @return string
     */
    public function getDistroVersion(): string
    {
        return $this->distroVersion;
    }

    /**
     * @param string $distroVersion
     */
    public function setDistroVersion(string $distroVersion): void
    {
        $this->distroVersion = $distroVersion;
    }

    /**
     * @return string
     */
    public function getKernel(): string
    {
        return $this->kernel;
    }

    /**
     * @param string $kernel
     */
    public function setKernel(string $kernel): void
    {
        $this->kernel = $kernel;
    }
}
