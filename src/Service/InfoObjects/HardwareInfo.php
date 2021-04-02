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
 * Class HardwareInfo.
 */
class HardwareInfo
{
    /**
     * @var array
     */
    private $cpus;

    /**
     * @var string
     */
    private $architecture;

    /**
     * @var string
     */
    private $serverModel;

    /**
     * @var int
     */
    private $ramTotal;

    /**
     * @var int
     */
    private $swapTotal;

    public function init(): self
    {
        try {
            $linfo = new Linfo();
            /** @var OS $parser */
            $parser = $linfo->getParser();
            $cpus = $parser->getCPU();
            $ram = $parser->getRAM();
            $model = $parser->getModel();
            $architecture = $parser->getCPUArchitecture();

            $this->setCpus($cpus);
            $this->setArchitecture($architecture ?: '-');
            $this->setServerModel($model ?: '-');
            $this->setRamTotal($ram['total'] ?? 0);
            $this->setSwapTotal($ram['swapTotal'] ?? 0);
        } catch (FatalException $e) {
            $this->setCpus([]);
            $this->setArchitecture(php_uname('m'));
            $this->setServerModel('-');
            $this->setRamTotal(0);
            $this->setSwapTotal(0);
        }

        return $this;
    }

    public function getCpus(): array
    {
        return $this->cpus;
    }

    public function setCpus(array $cpus): void
    {
        $this->cpus = $cpus;
    }

    public function getArchitecture(): string
    {
        return $this->architecture;
    }

    public function setArchitecture(string $architecture): void
    {
        $this->architecture = $architecture;
    }

    public function getServerModel(): string
    {
        return $this->serverModel;
    }

    public function setServerModel(string $serverModel): void
    {
        $this->serverModel = $serverModel;
    }

    public function getRamTotal(): int
    {
        return $this->ramTotal;
    }

    public function setRamTotal(int $ramTotal): void
    {
        $this->ramTotal = $ramTotal;
    }

    public function getRamTotalInGiB(): float
    {
        return round($this->getRamTotal() / 1024 / 1024 / 1024, 1);
    }

    public function getSwapTotal(): int
    {
        return $this->swapTotal;
    }

    public function setSwapTotal(int $swapTotal): void
    {
        $this->swapTotal = $swapTotal;
    }

    public function getSwapTotalInGiB(): float
    {
        return round($this->getSwapTotal() / 1024 / 1024 / 1024, 1);
    }
}
