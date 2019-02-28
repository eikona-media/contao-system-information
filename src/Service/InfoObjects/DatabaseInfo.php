<?php

/*
 * This file is part of System Information Bundle for Contao Open Source CMS.
 *
 * (c) eikona-media.de
 *
 * @license MIT
 */

namespace EikonaMedia\Contao\SystemInformation\Service\InfoObjects;

use Contao\Database;

/**
 * Class DatabaseInfo
 * @package EikonaMedia\Contao\SystemInformation\Service\InfoObjects
 */
class DatabaseInfo
{
    /**
     * @var string $version
     */
    private $version;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var array $sqlModes
     */
    private $sqlModes;

    /**
     * DatabaseInfo constructor.
     */
    public function __construct()
    {
        $db = Database::getInstance();

        // get version and type
        $resultVersion = $db->query('SHOW GLOBAL VARIABLES LIKE "%version%"');
        $version = '';
        $type = '';
        if ($resultVersion->count() > 0) {
            while ($row = $resultVersion->fetchRow()) {
                switch ($row[0]) {
                    case 'version':
                        $version = $row[1];
                        break;
                    case 'version_comment':
                        $type = $row[1];
                        break;
                }
            }
        }
        $this->setVersion($version);
        $this->setType($type);

        // get modes
        $resultModes = $db->query('SHOW GLOBAL VARIABLES LIKE "%mode%"');
        $sqlModes = [];
        if ($resultModes->count() > 0) {
            while ($row = $resultModes->fetchRow()) {
                switch ($row[0]) {
                    case 'sql_mode':
                        $sqlModes = explode(',', $row[1]);
                        break;
                }
            }
        }
        $this->setSqlModes($sqlModes);
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
     * @return array
     */
    public function getSqlModes(): array
    {
        return $this->sqlModes;
    }

    /**
     * @param array $sqlModes
     */
    public function setSqlModes(array $sqlModes): void
    {
        $this->sqlModes = $sqlModes;
    }
}
