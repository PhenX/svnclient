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

class Util {

  /**
   * Execute an SVN command
   *
   * @param string $cmd       Command name (update, info, etc)
   * @param array  $arguments An array of argument (path, url, etc)
   * @param array  $options   An array of options
   * @param string $path      Working directory
   *
   * @return string
   * @throws \Exception
   */
  public static function exec($cmd, $arguments = array(), $options = array(), $path = null) {
    if (!is_array($arguments)) {
      $arguments = array($arguments);
    }
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

    $cmdline = "svn $cmd " . implode(" ", $arguments) . " " . implode(" ", $new_options);

    //var_dump($cmdline);

    $pipes   = array();
    $process = proc_open($cmdline, $opts, $pipes, $path);

    if (is_resource($process)) {
      $err = stream_get_contents($pipes[2]);
      fclose($pipes[2]);
      if ($err) {
        throw new Exception($err);
      }

      //fwrite($pipes[0], 'Init OK');
      fclose($pipes[0]);

      $out = stream_get_contents($pipes[1]);
      fclose($pipes[1]);

      proc_close($process);

      return $out;
    }

    throw new Exception("'$cmdline' could not be executed");
  }

  /**
   * @param $xml
   *
   * @return \SimpleXMLElement[]
   */
  public static function parseXML($xml) {
    $dom = simplexml_load_string($xml);

    foreach ($dom->children() as $child) {
      return $child;
    }
  }
}