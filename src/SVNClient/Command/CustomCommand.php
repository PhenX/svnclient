<?php
/**
 * SVN update command
 *
 * @package SVNClient
 * @link    https://github.com/PhenX/svnclient
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license MIT License (MIT)
 */

namespace SVNClient\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SVNClient\WorkingCopy;

class CustomCommand extends Command {
  protected function configure() {
    $this
      ->setName('svn:cmd')
      ->setDescription("Custom command")
      ->addArgument(
        'path',
        InputArgument::REQUIRED,
        'The working copy dir'
      )
      ->addArgument(
        'cmd',
        InputArgument::REQUIRED,
        'The command to execute'
      )
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $path = $input->getArgument('path');
    $command = $input->getArgument('cmd');

    $wc = new WorkingCopy($path);
    var_dump($wc->$command());

    $output->writeln("'$command' command executed on '$path'");
  }
}