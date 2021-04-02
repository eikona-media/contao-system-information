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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

/**
 * Class DatabaseInfo.
 */
class DatabaseInfo
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $sqlModes;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function init(): self
    {
        // get version and type
        try {
            $resultVersion = $this->connection->executeQuery('SHOW GLOBAL VARIABLES LIKE "%version%"');
        } catch (\Doctrine\DBAL\Exception $e) {
        }
        $version = '';
        $type = '';

        if (isset($resultVersion) && $resultVersion->rowCount() > 0) {
            try {
                while (false !== ($row = $resultVersion->fetchAssociative())) {
                    switch ($row['Variable_name']) {
                        case 'version':
                            $version = $row['Value'];
                            break;

                        case 'version_comment':
                            $type = $row['Value'];
                            break;
                    }
                }
            } catch (Exception $e) {
            }
        }
        $this->setVersion($version);
        $this->setType($type);

        // get modes
        try {
            $resultModes = $this->connection->executeQuery('SHOW GLOBAL VARIABLES LIKE "%mode%"');
        } catch (\Doctrine\DBAL\Exception $e) {
        }
        $sqlModes = [];

        if (isset($resultModes) && $resultModes->rowCount() > 0) {
            try {
                while (false !== ($row = $resultModes->fetchAssociative())) {
                    switch ($row['Variable_name']) {
                        case 'sql_mode':
                            $sqlModes = explode(',', $row['Value']);
                            break;
                    }
                }
            } catch (Exception $e) {
            }
        }
        $this->setSqlModes($sqlModes);

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getSqlModes(): array
    {
        return $this->sqlModes;
    }

    public function setSqlModes(array $sqlModes): void
    {
        $this->sqlModes = $sqlModes;
    }
}
