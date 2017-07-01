<?php

namespace Oro\Component\Database\Service;

use Oro\Component\Database\Engine\DatabaseEngineInterface;
use Oro\Component\Database\Exception\EngineNotFoundException;
use Oro\Component\Database\Model\DatabaseConfigurationInterface;

class DatabaseEngineRegistry
{
    const SERVICE_TAG = 'oro.database.isolator';

    /** @var array|DatabaseEngineInterface[] */
    protected $isolators = [];

    /**
     * @param DatabaseEngineInterface $databaseIsolator
     * @param string $alias
     */
    public function addEngine(DatabaseEngineInterface $databaseIsolator, $alias)
    {
        $this->isolators[$alias] = $databaseIsolator;
    }

    /**
     * @param DatabaseConfigurationInterface $configuration
     *
     * @return DatabaseEngineInterface
     *
     * @throws EngineNotFoundException
     */
    public function findEngine(DatabaseConfigurationInterface $configuration)
    {
        foreach ($this->isolators as $isolator) {
            if ($isolator->isConfigurationSupported($configuration)) {
                return $isolator;
            }
        }

        throw new EngineNotFoundException(sprintf('Engine not found for %s', serialize($configuration)));
    }
}
