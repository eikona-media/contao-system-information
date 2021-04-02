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
 * Class OSInfo.
 */
class OSInfo
{
    /**
     * @var string
     */
    private $os;

    /**
     * @var string
     */
    private $distroName;

    /**
     * @var string
     */
    private $distroVersion;

    /**
     * @var string
     */
    private $kernel;

    public function init(): self
    {
        try {
            $linfo = new Linfo();
            /** @var OS $parser */
            $parser = $linfo->getParser();
            $os = $parser->getOS();
            $distro = $parser->getDistro();
            $kernel = $parser->getKernel();

            $this->setOs($os);
            $this->setDistroName($distro['name'] ?? '');
            $this->setDistroVersion($distro['version'] ?? '');
            $this->setKernel($kernel);
        } catch (FatalException $e) {
            $this->setOs(PHP_OS_FAMILY);
            $this->setDistroName(PHP_OS);
            $this->setDistroVersion(php_uname('v'));
            $this->setKernel(php_uname('r'));
        }

        return $this;
    }

    public function getOs(): string
    {
        return $this->os;
    }

    public function setOs(string $os): void
    {
        $this->os = $os;
    }

    public function getDistroName(): string
    {
        return $this->distroName;
    }

    public function setDistroName(string $distroName): void
    {
        $this->distroName = $distroName;
    }

    public function getDistroVersion(): string
    {
        return $this->distroVersion;
    }

    public function setDistroVersion(string $distroVersion): void
    {
        $this->distroVersion = $distroVersion;
    }

    public function getKernel(): string
    {
        return $this->kernel;
    }

    public function setKernel(string $kernel): void
    {
        $this->kernel = $kernel;
    }
}
