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

class Update extends Command {
  protected function configure() {
    $this
      ->setName('svn:update')
      ->setDescription("Update working copy")
      ->addArgument(
        'path',
        InputArgument::REQUIRED,
        'Where is the working copy ?'
      )
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $path = $input->getArgument('path');

    $wc = new WorkingCopy($path);
    $wc->update();

    $output->writeln("'$path' updated");
  }
}