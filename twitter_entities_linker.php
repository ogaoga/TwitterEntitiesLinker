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
					"TwitterEntitiesLinker::sortFunction");

    // split entities and texts
		$pos = 0;
		$entities = array();
    foreach ($convertedEntities as $entity) {
			// not entity
			if ( $pos < $entity->indices[0] ) {
				$substring = mb_substr($tweet->text,
															 $pos,
															 $entity->indices[0] - $pos,
															 'utf-8');
				$entities[] = array('text' => $substring, 
														'data' => null);
				$pos = $entity->indices[0];
			}
			// entity
			$substring = mb_substr($tweet->text,
														 $pos,
														 $entity->indices[1] - $entity->indices[0],
														 'utf-8');
			$entities[] = array('text' => $substring, 
													'data' => $entity);
			$pos = $entity->indices[1];
		}
		// tail of not entity
		$length = mb_strlen($tweet->text, 'utf-8');
		if ( $pos < $length ) {
			$substring = mb_substr($tweet->text,
														 $pos,
														 $length - $pos,
														 'utf-8');
			$entities[] = array('text' => $substring, 
													'data' => null);
		}

		// replace
		$html = "";
		foreach ( $entities as $entity ) {
			if ( $entity['data'] ) {
				if ( $entity['data']->type == 'urls' ) {
					$url = ($entity['data']->expanded_url) ? $entity['data']->expanded_url : $entity['data']->url;
					$html .= '<a href="'.$url.'" target="_blank" rel="nofollow" class="twitter-timeline-link">'.$url.'</a>';
				}
				else if ( $entity['data']->type == 'hashtags' ) {
					$text = $entity['data']->text;
					$html .= '<a href="http://twitter.com/#!/search?q=%23'.$text.'" title="#'.$text.'" class="twitter-hashtag" rel="nofollow">#'.$text.'</a>';
				}
				else if ( $entity['data']->type == 'user_mentions' ) {
					$screen_name = $entity['data']->screen_name;
					$html .= '@<a class="twitter-atreply" data-screen-name="'.$screen_name.'" href="http://twitter.com/'.$screen_name.'" rel="nofollow">'.$screen_name.'</a>';
				}
				else {
				}
			}
			else {
				$html .= $entity['text'];
			}
		}
    // return 
    return $html;
	}

  /**
   * sort function
   *
   * @param   data a
   * @param   data b
   * @return  1 or -1 or 0
   */
	static private function sortFunction($a, $b)  {
		if ($a->indices > $b->indices) { return 1; }
		else if ($a->indices < $b->indices) { return -1; }
		else { return 0; }
	}

}
?>
