<?php
/**
 * Test for Twitter Entities Linker class.
 *
 * PHP versions 5
 *
 * Copyright 2010, ogaoga.org
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010, ogaoga.org
 * @link          http://www.ogaoga.org/
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

include_once('twitter_entities_linker.php');

$tweets = json_decode(file_get_contents('testdata.json'));
var_dump($tweets);
$html = '<!DOCTYPE html><html lang="ja"><head><meta charset="UTF-8" /></head><body>';
foreach ( $tweets as $tweet ) {
	$html .= '<div class="tweet">'."\n";
  $result = TwitterEntitiesLinker::getHtml($tweet);
	$html .= $result."\n";
	$html .= '</div>'."\n";
}
$html .= '</body></html>';
echo $html;

?>
