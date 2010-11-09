<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

/**
 * Twitter Entities Linker class
 */
class TwitterEntitiesLinker {
	private $data;

	public function __construct($json) {
		$this->data = json_decode($json);
	}

	public function getHtml() {
		$html = "";
		foreach ($this->data as $tweet) {
			$html .= '<div class="tweet">';
			$html .= $this->_convertTweet($tweet);
			$html .= '<div>';
		}
		return print_r($this->data, true);
	}

	private function _convertTweet($tweet) {
		
	}
}

/**
 * test
 */
$json = file_get_contents('testdata.json');
$linker = new TwitterEntitiesLinker($json);
echo $linker->getHtml();

?>
