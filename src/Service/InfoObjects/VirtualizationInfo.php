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
 * Class VirtualizationInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class VirtualizationInfo
{
    /**
     * @var string $type
     */
    private $type;

    /**
     * @var string $method
     */
    private $method;

    /**
     * PHPInfo constructor.
     */
    public function __construct()
    {
        $linfo = new Linfo();
        $parser = $linfo->getParser();
        $virtualization = $parser->getVirtualization();

        $this->setType($virtualization['type'] ?? '');
        $this->setMethod($virtualization['method'] ?? '');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
}
