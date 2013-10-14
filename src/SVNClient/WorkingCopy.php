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

  /** @var string */
  private $url;

  /** @var int */
  private $revision;

  /** @var Repository */
  protected $repository;

  function __construct($path) {
    if (!is_dir($path)) {
      throw new Exception("'$path' does not exist");
    }

    $this->path = $path;

    $xml = $this->info();

    $data = Util::parseXML($xml);
    $this->url = (string)$data->url;
    $this->revision = (int)$data->commit->attributes()->revision;

    $repo = $data->repository;
    $this->repository = new Repository((string)$repo->root, (string)$repo->uuid);
  }

  // Get folders
  function getBranches(){
    return $this->repository->getBranches();
  }

  function getTags(){
    return $this->repository->getTags();
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

    return Util::exec("update", $paths, $options, $this->path);
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

    return Util::exec("info", $file, $options, $this->path);
  }

  // Properties
  function getProperty($path, $name) {
    return Util::exec("propget", array($name, $path), array(), $this->path);
  }

  function setProperty($path, $name, $value) {
    return Util::exec("propset", array($name, $value, $path), array(), $this->path);
  }

  function removeProperty($path, $name) {
    return Util::exec("propdel", array($name, $path), array(), $this->path);
  }

  function listProperties($path) {
    $options = array(
      "--xml" => true,
    );

    $xml = Util::exec("proplist", $path, $options, $this->path);
    $data = DOM::parse($xml);

    $properties = $data->xpath("//property");

    $list = array();
    foreach ($properties as $prop) {
      $list[$prop->getAttribute("name")] = trim($prop->textContent);
    }

    return $list;
  }
} 