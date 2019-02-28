<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Service\InfoObjects;

/**
 * Class PHPInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class PHPInfo
{
    /**
     * @var string $version
     */
    private $version;

    /**
     * @var array $extensions
     */
    private $extensions;

    /**
     * PHPInfo constructor.
     */
    public function __construct()
    {
        // collect php information
        $this->setVersion(PHP_VERSION);
        $this->setExtensions(get_loaded_extensions());
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return array
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @param array $extensions
     */
    public function setExtensions(array $extensions): void
    {
        $this->extensions = $extensions;
    }
}
