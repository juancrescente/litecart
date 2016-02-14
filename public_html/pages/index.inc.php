<?php

  document::$snippets['title'][] = language::translate('index:head_title', 'One fancy web shop');
  document::$snippets['description'] = language::translate('index:meta_description', '');
  
  document::$snippets['head_tags']['canonical'] = '<link rel="canonical" href="'. document::href_ilink('') .'" />';
  
  document::$snippets['head_tags']['opengraph'] = '<meta property="og:url" content="'. document::href_ilink('') .'" />' . PHP_EOL
                                                //. '<meta property="og:title" content="'. htmlspecialchars(language::translate('index.php:head_title')) .'" />' . PHP_EOL
                                                //. '<meta property="og:description" content="'. htmlspecialchars(language::translate('index.php:meta_description')) .'" />' . PHP_EOL
                                                . '<meta property="og:type" content="website" />' . PHP_EOL
                                                . '<meta property="og:image" content="'. document::href_link(WS_DIR_IMAGES . 'logotype.png') .'" />';
  
  $_page = new view();
  
  echo $_page->stitch('pages/index');
?>
