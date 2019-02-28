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
 * Class HardwareInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class HardwareInfo
{
    /**
     * @var array $cpus
     */
    private $cpus;

    /**
     * @var string $architecture
     */
    private $architecture;

    /**
     * @var string $serverModel
     */
    private $serverModel;

    /**
     * @var int $ramTotal
     */
    private $ramTotal;

    /**
     * @var int $swapTotal
     */
    private $swapTotal;

    /**
     * HardwareInfo constructor.
     */
    public function __construct()
    {
        $linfo = new Linfo();
        $parser = $linfo->getParser();
        $cpus = $parser->getCPU();
        $ram = $parser->getRAM();
        $model = $parser->getModel();
        $architecture = $parser->getCPUArchitecture();

        $this->setCpus($cpus);
        $this->setArchitecture($architecture);
        $this->setServerModel($model);
        $this->setRamTotal($ram['total'] ?? 0);
        $this->setSwapTotal($ram['swapTotal']  ?? 0);
    }

    /**
     * @return array
     */
    public function getCpus(): array
    {
        return $this->cpus;
    }

    /**
     * @param array $cpus
     */
    public function setCpus(array $cpus): void
    {
        $this->cpus = $cpus;
    }

    /**
     * @return string
     */
    public function getArchitecture(): string
    {
        return $this->architecture;
    }

    /**
     * @param string $architecture
     */
    public function setArchitecture(string $architecture): void
    {
        $this->architecture = $architecture;
    }

    /**
     * @return string
     */
    public function getServerModel(): string
    {
        return $this->serverModel;
    }

    /**
     * @param string $serverModel
     */
    public function setServerModel(string $serverModel): void
    {
        $this->serverModel = $serverModel;
    }

    /**
     * @return int
     */
    public function getRamTotal(): int
    {
        return $this->ramTotal;
    }

    /**
     * @param int $ramTotal
     */
    public function setRamTotal(int $ramTotal): void
    {
        $this->ramTotal = $ramTotal;
    }

    /**
     * @return float
     */
    public function getRamTotalInGiB(): float
    {
        return round($this->getRamTotal() / 1024 / 1024 / 1024, 1);
    }

    /**
     * @return int
     */
    public function getSwapTotal(): int
    {
        return $this->swapTotal;
    }

    /**
     * @param int $swapTotal
     */
    public function setSwapTotal(int $swapTotal): void
    {
        $this->swapTotal = $swapTotal;
    }

    /**
     * @return float
     */
    public function getSwapTotalInGiB(): float
    {
        return round($this->getSwapTotal() / 1024 / 1024 / 1024, 1);
    }
}
