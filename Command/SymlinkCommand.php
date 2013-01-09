<?php

namespace Snowcap\BootstrapBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymlinkCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('snowcap:bootstrap:symlink')
            ->setDescription('Create a symlink in the public diretory, pointing to the Twitter Bootstrap files in vendor')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command copy the Twitter Bootstrap files in the
Snowcap BootstrapBundle public directory.

<info>php %command.full_name%</info>
EOT
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \ErrorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!function_exists('symlink')) {
            throw new \ErrorException('The symlink() function is not available on your system.');
        }

        $filesystem = $this->getContainer()->get('filesystem');

        $output->writeln("Symlinking Twitter Bootstrap");
        $bundleDir = realpath(__DIR__ . '/../');
        $targetDir  = $bundleDir . '/Resources/public/vendor/twitter';

        $originDir = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../vendor/twitter/bootstrap/twitter');

        $filesystem->symlink($originDir, $targetDir);
    }
}