<?php
/**
 * Class loader
 *
 * @package SVNClient
 * @link    https://github.com/PhenX/svnclient
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license MIT License (MIT)
 */

require "vendor/autoload.php";

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespace("SVNClient", __DIR__."/src");
$loader->register();
