<?php
/**
 * Twitter Entities Linker class.
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

/**
 * Twitter Entities Linker class
 *
 * 
 *
 */
class TwitterEntitiesLinker {

  /**
   * get html source
   *
   * @return 
   */
	public static function getHtml($tweet) {
		return self::_convertTweet($tweet);
	}

  /**
   * convert tweet to html
   *
   * @param   tweet object
   * @return  html source including links.
   */
	private static function _convertTweet($tweet) {
    $convertedEntities = array();
    // check entities data exists
    if ( ! isset($tweet->entities) ) {
      return $tweet->text;
    }
    // make entities array
    foreach ( $tweet->entities as $type => $entities ) {
      foreach ( $entities as $entity ) {
        $entity->type = $type;
        $convertedEntities[] = $entity;
      }
    }
    // sort entities
    usort(&$convertedEntities,
          function($a, $b) {
            if ($a->indices > $b->indices) { return 1; }
            else if ($a->indices < $b->indices) { return -1; }
            else { return 0; }
          });
    // 
    foreach ($convertedEntities as $entity) {
      var_dump(mb_substr($tweet->text,
                         $entity->indices[0],
                         $entity->indices[1] - $entity->indices[0],
                         'utf-8'));
    }
    // return 
    return null;
	}
}

?>
