<?php

namespace Oro\Component\Database\Engine;

use Oro\Component\Database\Model\DatabaseConfigurationInterface;

abstract class AbstractDatabaseEngine implements DatabaseEngineInterface
{
    const SALT = 'backup';

    const OS_WINDOWS = 'WINDOWS';
    const OS_LINUX = 'LINUX';
    const OS_MAC = 'DARWIN';
    const OS_UNKNOWN = 'UNKNOWN';

    /**
     * @return array
     */
    abstract public function getSupportedOs();

    /**
     * @return array
     */
    abstract public function getSupportedDrivers();

    /**
     * @return string
     */
    protected function getCurrentOs()
    {
        switch (PHP_OS) {
            case 'WINNT':
                return self::OS_WINDOWS;
                break;
            case 'Linux':
                return self::OS_LINUX;
                break;
            case 'Darwin':
                return self::OS_MAC;
                break;
            default:
                return self::OS_UNKNOWN;
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isConfigurationSupported(DatabaseConfigurationInterface $databaseConfiguration)
    {
        return $databaseConfiguration->isValid() &&
        in_array($databaseConfiguration->getDriver(), $this->getSupportedDrivers(), true) &&
        in_array($this->getCurrentOs(), $this->getSupportedOs(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function getBackupDbName($id, DatabaseConfigurationInterface $databaseConfiguration)
    {
        return sprintf('%s_%s_%s', self::SALT, $databaseConfiguration->getDbName(), $id);
    }
}
