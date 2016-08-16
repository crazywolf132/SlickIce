<?php
namespace Concrete\Core\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Exception;
use Concrete\Core\Support\Facade\Facade;
use Concrete\Core\System\Info;

class InfoCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('c5:info')
            ->setDescription('Get server and concrete5 detailed informations.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rc = 0;

        try {
            $info = Facade::getFacadeApplication()->make(Info::class);
            /* @var Info $info */

            $output->writeln('<info># concrete5 Version</info>');
            $output->writeln('Installed - '.($info->isInstalled() ? 'Yes' : 'No'));
            $output->writeln($info->getCoreVersions());

            $output->writeln('');
            $output->writeln('<info># Paths</info>');
            $output->writeln('Web root - '.$info->getWebRootDirectory());
            $output->writeln('Core root - '.$info->getCoreRootDirectory());

            $output->writeln('');
            $output->writeln('<info># concrete5 Packages</info>');
            $output->writeln($info->getPackages() ?: 'None');

            $output->writeln('');
            $output->writeln('<info># concrete5 Overrides</info>');
            $output->writeln($info->getOverrides() ?: 'None');

            $output->writeln('');
            $output->writeln('<info># concrete5 Cache Settings</info>');
            $output->writeln($info->getCache());

            $output->writeln('');
            $output->writeln('<info># Server API</info>');
            $output->writeln($info->getServerAPI());

            $output->writeln('');
            $output->writeln('<info># PHP Version</info>');
            $output->writeln($info->getPhpVersion());

            $output->writeln('');
            $output->writeln('<info># PHP Extensions</info>');
            $output->writeln(($info->getPhpExtensions() === false ? 'Unable to determine' : $info->getPhpExtensions()));

            $output->writeln('');
            $output->writeln('<info># PHP Settings</info>');
            $output->writeln($info->getPhpSettings());
        } catch (Exception $x) {
            $output->writeln('<error>'.$x->getMessage().'</error>');
            $rc = 1;
        }

        return $rc;
    }
}
