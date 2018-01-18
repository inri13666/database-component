<?php

namespace Gorgo13\Component\Database\Model;

class DoctrineConfigurationHelper
{
    /**
     * @param \Doctrine\DBAL\Connection $connection
     *
     * @return DoctrineConfigurationHelper
     */
    public static function fromDbalConnection(\Doctrine\DBAL\Connection $connection)
    {
        $conf = new DatabaseConfigurationModel();
        $conf->setDriver($connection->getDriver()->getName())
            ->setHost($connection->getHost())
            ->setPassword($connection->getPassword())
            ->setDbName($connection->getDatabase())
            ->setUser($connection->getUsername())
            ->setPort($connection->getPort());

        return $conf;
    }
}
