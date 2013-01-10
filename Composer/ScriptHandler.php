<?php

namespace Snowcap\BootstrapBundle\Composer;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

class ScriptHandler
{
    public static function symlinkBootstrap($event)
    {
        $appDir = 'app';

        if (!is_dir($appDir)) {
            $event->getIO()->write(sprintf('Cannot find "%s" app directory'));

            return;
        }

        $event->getIO()->write("Checking Symlink", FALSE);

        $timeOut = $event->getComposer()->getConfig()->get('process-timeout');
        static::executeCommand($event, $appDir, 'snowcap:bootstrap:symlink', $timeOut);

        $event->getIO()->write("OK");
    }

    protected static function executeCommand($event, $appDir, $cmd, $timeout = 300)
    {
        $php = escapeshellarg(self::getPhp());
        $console = escapeshellarg($appDir.'/console');
        if ($event->getIO()->isDecorated()) {
            $console.= ' --ansi';
        }

        $process = new Process($php.' '.$console.' '.$cmd, null, null, null, $timeout);
        $process->run(function ($type, $buffer) { echo $buffer; });
        if (!$process->isSuccessful()) {
            throw new \RuntimeException(sprintf('An error occurred when executing the "%s" command.', escapeshellarg($cmd)));
        }
    }

    protected static function getPhp()
    {
        $phpFinder = new PhpExecutableFinder;
        if (!$phpPath = $phpFinder->find()) {
            throw new \RuntimeException('The php executable could not be found, add it to your PATH environment variable and try again');
        }

        return $phpPath;
    }
}