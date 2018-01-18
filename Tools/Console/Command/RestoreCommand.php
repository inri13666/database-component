<?php

namespace Gorgo13\Component\Database\Tools\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RestoreCommand extends AbstractCommand
{
    const NAME = 'gorgo13:restore';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->addOption('id', null, InputOption::VALUE_REQUIRED, '', null)
            ->addOption('remove', null, InputOption::VALUE_NONE, '', null);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = $this->getDatabaseConfiguration();
        $engine = $this->getEnginesRegistry()->findEngine($configuration);
        $sid = $input->getOption('id');
        $engine->restore($sid, $configuration);
        $output->writeln(sprintf('Restored dump with sid <info>%s</info>', $sid));
        if ($input->getOption('remove')) {
            $engine->drop($engine->getBackupDbName($sid, $configuration), $configuration);
            $output->writeln(sprintf('Backup with sid <info>%s</info> was dropped', $sid));
        }
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::NAME;
    }
}
