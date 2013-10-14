<?php
/**
 * DOM document
 *
 * @package SVNClient
 * @link    https://github.com/PhenX/svnclient
 * @author  Fabien Ménager <fabien.menager@gmail.com>
 * @license MIT License (MIT)
 */

namespace SVNClient;

class DOM extends \DOMDocument {
  /**
   * @param             $query
   * @param \DOMElement $node
   *
   * @return \DOMNodeList|\DOMElement[]
   */
  function xpath($query, \DOMElement $node = null) {
    $xpath = new \DOMXPath($this);
    return $xpath->query($query, $node);
  }

  /**
   * Parse an XML document to DOM
   *
   * @param string $xml CML content
   *
   * @return DOM
   */
  static function parse($xml) {
    $dom = new self;
    $dom->loadXML($xml);
    return $dom;
  }
}