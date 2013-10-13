<?php
/**
 * Working copy class
 *
 * @package SVNClient
 * @link    https://github.com/PhenX/svnclient
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license MIT License (MIT)
 */

namespace SVNClient;

class WorkingCopy {
  /** @var string */
  private $path;

  /** @var resource */
  private $process;

  /** @var string */
  private $url;

  /** @var int */
  private $revision;

  /** @var int */
  private $repository_revision;

  /** @var string */
  private $root;

  /** @var string */
  private $uuid;

  function __construct($path) {
    if (!is_dir($path)) {
      throw new \Exception("'$path' does not exist");
    }

    $this->path = $path;

    $xml = $this->info();

    $dom = simplexml_load_string($xml);
    $entry = $dom->entry;

    $this->url = (string)$entry->url;
    $this->revision = (int)$entry->commit->attributes()->revision;
    $this->repository_revision = (int)$entry->attributes()->revision;
    $this->root = (string)$entry->repository->root;
    $this->uuid = (string)$entry->repository->uuid;
  }

  private function exec($cmd, $arguments = array(), $options = array()) {
    $arguments = array_map("escapeshellarg", $arguments);

    $opts = array(
      0 => array("pipe", "r"), // stdin
      1 => array("pipe", "w"), // stdout
      2 => array("pipe", "w"), // stderr
    );

    $new_options = array();
    foreach ($options as $key => $value) {
      $new_options[] = preg_replace("/[^-\w]/", "", $key);

      if ($value !== true) {
        $new_options[] = escapeshellarg($value);
      }
    }

    $cmdline = "svn $cmd ".implode(" ", $arguments)." ".implode(" ", $new_options);

    $pipes = array();
    $this->process = proc_open($cmdline, $opts, $pipes, $this->path);

    if (is_resource($this->process)) {
      $err = stream_get_contents($pipes[2]);
      fclose($pipes[2]);
      if ($err) {
        throw new \Exception($err);
      }

      //fwrite($pipes[0], 'Init OK');
      fclose($pipes[0]);

      $out = stream_get_contents($pipes[1]);
      fclose($pipes[1]);
      return $out;
    }

    return false;
  }

  // Get folders
  function getBranches(){

  }

  function getTags(){

  }

  // Commands
  function checkout($url) {

  }

  function add($files, $message) {

  }

  function revert($files, $message) {

  }

  function relocate($to) {

  }

  function commit($files, $message) {

  }

  function update(array $paths = array(), $revision = "HEAD") {
    $options = array(
      "--revision" => $revision,
    );

    return $this->exec("update", $paths, $options);
  }

  function cleanup($path) {

  }

  function log($path) {

  }

  function blame($file) {

  }

  function info($file = ".") {
    $options = array(
      "--xml" => true,
    );

    return $this->exec("info", array($file), $options);
  }

  // Properties
  function setProperty($path, $name, $value) {

  }

  function removeProperty($path, $name) {

  }

  function listProperties($path) {

  }
} 