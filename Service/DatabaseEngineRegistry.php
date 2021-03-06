<?php

namespace Gorgo13\Component\Database\Service;

use Gorgo13\Component\Database\Engine\DatabaseEngineInterface;
use Gorgo13\Component\Database\Exception\EngineNotFoundException;
use Gorgo13\Component\Database\Model\DatabaseConfigurationInterface;

class DatabaseEngineRegistry
{
    const SERVICE_TAG = 'gorgo13.database.engine_registry';

    /** @var array|DatabaseEngineInterface[] */
    protected $engines = [];

    /**
     * @param DatabaseEngineInterface $databaseEngine
     * @param string $alias
     */
    public function addEngine(DatabaseEngineInterface $databaseEngine, $alias = null)
    {
        $this->engines[$alias ?: $databaseEngine->getName()] = $databaseEngine;
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
        foreach ($this->engines as $isolator) {
            if ($isolator->isConfigurationSupported($configuration)) {
                return $isolator;
            }
        }

        throw new EngineNotFoundException(sprintf('Engine not found for %s', serialize($configuration)));
    }
}
