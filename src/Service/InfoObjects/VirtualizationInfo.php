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
 * Class VirtualizationInfo.
 */
class VirtualizationInfo
{
    private string $type;
    private string $method;

    public function init(): self
    {
        try {
            $linfo = new Linfo();
            /** @var OS $parser */
            $parser = $linfo->getParser();
            $virtualization = $parser->getVirtualization();

            $this->setType($virtualization['type'] ?? '');
            $this->setMethod($virtualization['method'] ?? '');
        } catch (FatalException $e) {
            $this->setType('-');
            $this->setMethod('-');
        }

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
}
