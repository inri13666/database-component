<?php

namespace Gorgo13\Component\Database\Tools\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends AbstractCommand
{
    const NAME = 'gorgo13:dump';

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->addOption('id', null, InputOption::VALUE_OPTIONAL, '', (new \DateTime())->format('Ymdhis'));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $configuration = $this->getDatabaseConfiguration();
        $engine = $this->getEnginesRegistry()->findEngine($configuration);
        $sid = $input->getOption('id');
        $engine->dump($sid, $configuration);
        $output->writeln(sprintf('Generated dump with sid <info>%s</info>', $sid));
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return self::NAME;
    }
}
