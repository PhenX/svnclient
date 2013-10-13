#!/usr/bin/env php
<?php
/**
 * Console
 *
 * @package SVNClient
 * @link    https://github.com/PhenX/svnclient
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license MIT License (MIT)
 */

use SVNClient\Command;
use Symfony\Component\Console\Application;

require "autoload.php";

$application = new Application();
$application->add(new Command\Init());
$application->add(new Command\Update());
$application->run();
