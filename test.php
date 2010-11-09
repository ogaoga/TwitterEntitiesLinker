<?php

// retrieve entities
$tweets = json_decode(file_get_contents('testdata2.json'));
foreach ( $tweets as $tweet ) {
  // each tweet 
  $convertedEntities = array();
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
  //print_r($convertedEntities);
  // 
  foreach ($convertedEntities as $entity) {
    
    //var_dump(mb_substr($tweet->text, $entity->{0}, $entity->{1} - $entity->{0}, 'utf-8'));
    var_dump($entity);
  }
}

?>
