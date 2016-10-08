<?php

    $box_site_menu = new view();

  $box_site_menu_items_cache_id = cache::cache_id('box_site_menu_items', array('language'));
  if (($box_site_menu->snippets['items'] = cache::get($box_site_menu_items_cache_id, 'file')) === null) {

    $box_site_menu->snippets['items'] = array();

    if (!function_exists('custom_site_menu_category_tree')) {
      function custom_site_menu_category_tree($parent_id=0, $depth=0, $max_depth=1, &$output) {

        $categories_query = database::query(
          "select c.id, c.image, ci.name
          from ". DB_TABLE_CATEGORIES ." c
          left join ". DB_TABLE_CATEGORIES_INFO ." ci on (ci.category_id = c.id and ci.language_code = '". database::input(language::$selected['code']) ."')
          where status
          ". (empty($parent_id) ? "and find_in_set('menu', c.dock)" : "and parent_id = '". (int)$parent_id ."'") ."
          order by c.priority asc, ci.name asc;"
        );

        while ($category = database::fetch($categories_query)) {

          if ($parent_id == 0) {
            $output[$category['id']] = array(
              'type' => 'category',
              'id' => $category['id'],
              'title' => $category['name'],
              'link' => document::ilink('category', array('category_id' => $category['id'])),
              'image' => null,
              'subitems' => array(),
            );
          } else {
            $output[$category['id']] = array(
              'type' => 'category',
              'id' => $category['id'],
              'title' => $category['name'],
              'link' => document::ilink('category', array('category_id' => $category['id'])),
              'image' => functions::image_thumbnail(FS_DIR_HTTP_ROOT . WS_DIR_IMAGES . $category['image'], 24, 24, 'CROP'),
              'subitems' => array(),
            );
          }

          $subcategories_query = database::query(
            "select id
            from ". DB_TABLE_CATEGORIES ." c
            where status = 1
            and parent_id = '". (int)$category['id'] ."'
            limit 1;"
          );

          if ($depth != $max_depth && database::num_rows($subcategories_query) > 0) {
            custom_site_menu_category_tree($category['id'], $depth+1, $max_depth, $output[$category['id']]['subitems']);
          }
        }

        database::free($categories_query);
      }
    }

    custom_site_menu_category_tree(0, 0, 1, $box_site_menu->snippets['items']);

    $pages_query = database::query(
      "select p.id, pi.title from ". DB_TABLE_PAGES ." p
      left join ". DB_TABLE_PAGES_INFO ." pi on (p.id = pi.page_id and pi.language_code = '". language::$selected['code'] ."')
      where status
      and find_in_set('menu', dock)
      order by p.priority, pi.title;"
    );
    while ($page = database::fetch($pages_query)) {
      $box_site_menu->snippets['items'][] = array(
        'type' => 'page',
        'id' => $page['id'],
        'title' => $page['title'],
        'link' => document::ilink('information', array('page_id' => $page['id'])),
        'image' => null,
        'subitems' => array(),
      );
    }

     cache::set($box_site_menu_items_cache_id, 'file', $box_site_menu->snippets['items']);
  }

  echo $box_site_menu->stitch('views/box_site_menu');
?>