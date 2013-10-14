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

class Repository {
  /** @var string */
  private $url;

  /** @var string */
  private $uuid;

  function __construct($url, $uuid = null) {
    $this->url = $url;
    $this->uuid = $uuid;

    if (!$uuid) {
      $options = array(
        "--xml" => true,
      );
      $xml = Util::exec("info", $url, $options);

      $data = Util::parseXML($xml);
      $this->uuid = (string)$data->repository->uuid;
    }
  }

  protected function listDirectory($dir) {
    $options = array(
      "--xml" => true,
    );

    $xml = Util::exec("list", "$this->url/$dir", $options);
    $data = Util::parseXML($xml);

    $directories = array();
    foreach ($data->entry as $entry) {
      $commit = $entry->commit;
      $directories[] = array(
        "name"     => (string)$entry->name,
        "revision" =>    (int)$commit->attributes()->revision,
        "date"     => (string)$commit->date,
        "author"   => (string)$commit->author,
      );
    }

    return $directories;
  }

  // Get folders
  function getBranches(){
    return $this->listDirectory("branches");
  }

  function getTags(){
    return $this->listDirectory("tags");
  }
} 