<?php
  
  class document {
    
    public static $template = '';
    public static $layout = 'default';
    public static $snippets = array();
    public static $settings = array();
    
    public static function construct() {
      header('X-Powered-By: '. PLATFORM_NAME);
    }
    
    //public static function load_dependencies() {
    //}
    
    //public static function initiate() {
    //}
    
    //public static function startup() {
    //}
    
    public static function before_capture() {
      
    // Set template
      if (preg_match('#^('. preg_quote(WS_DIR_ADMIN, '#') .')#', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
        self::$template = settings::get('store_template_admin');
      } else {
        self::$template = settings::get('store_template_catalog');
      }
    
    // Set before-snippets
      self::$snippets['title'] = array(settings::get('store_name'));
      
      self::$snippets['head_tags']['X-UA-Compatible'] = '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
      
      self::$snippets['head_tags']['favicon'] = '<link rel="shortcut icon" href="'. WS_DIR_HTTP_HOME .'favicon.ico">';
      
      self::$snippets['head_tags']['bootstrap'] = '<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.3.6/css/bootstrap.min.css" />';
      self::$snippets['head_tags']['fontawesome'] = '<link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/latest/css/font-awesome.min.css" />';
      
      self::$snippets['head_tags']['html5shiv'] = '<!--[if lt IE 9]><script src="//cdn.jsdelivr.net/g/html5shiv"></script><![endif]-->';
      self::$snippets['head_tags']['respond'] = '<!--[if lt IE 9]><script src="//cdn.jsdelivr.net/g/respond"></script><![endif]-->';
      
      self::$snippets['head_tags']['jquery+bootstrap'] = '<script src="//cdn.jsdelivr.net/g/jquery@2.1.4,bootstrap@3.3.6" ></script>';
      
    // Hreflang
      if (!empty(route::$route['page']) && settings::get('seo_links_language_prefix')) {
        self::$snippets['head_tags']['hreflang'] = '';
        foreach (array_keys(language::$languages) as $language_code) {
          if ($language_code == language::$selected['code']) continue;
          self::$snippets['head_tags']['hreflang'] .= '<link rel="alternate" hreflang="'. $language_code .'" href="'. document::href_ilink(route::$route['page'], array(), true, array(), $language_code) .'" />' . PHP_EOL;
        }
        self::$snippets['head_tags']['hreflang'] = trim(self::$snippets['head_tags']['hreflang']);
      }
    }
    
    public static function after_capture() {
      
    // Extract javascript
      if (preg_match_all('#<script(?:.*?)>(.*?)</script>#is', $GLOBALS['content'], $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
          document::$snippets['javascript'][] = $match[1];
          $GLOBALS['content'] = str_replace($match[0], '', $GLOBALS['content']);
        }
      }
    
    // Set after-snippets
      self::$snippets['language'] = language::$selected['code'];
      self::$snippets['charset'] = language::$selected['charset'];
      self::$snippets['home_path'] = WS_DIR_HTTP_HOME;
      self::$snippets['template_path'] = WS_DIR_TEMPLATES . self::$template .'/';
    }
    
    public static function prepare_output() {
      
    // Prepare title
      if (!empty(self::$snippets['title'])) {
        if (!is_array(self::$snippets['title'])) self::$snippets['title'] = array(self::$snippets['title']);
        self::$snippets['title'] = array_filter(self::$snippets['title']);
        self::$snippets['title'] = implode(' | ', array_reverse(self::$snippets['title']));
      }
      
    // Prepare styles
      if (!empty(self::$snippets['styles'])) {
        self::$snippets['styles'] = '<style>' . PHP_EOL
                                  . '<!--/*--><![CDATA[/*><!--*/' . PHP_EOL
                                  . implode(PHP_EOL . PHP_EOL, self::$snippets['styles']) . PHP_EOL
                                  . '/*]]>*/-->' . PHP_EOL
                                  . '</style>' . PHP_EOL;
      }
      
    // Prepare javascript
      if (!empty(self::$snippets['javascript'])) {
        self::$snippets['javascript'] = '<script>' . PHP_EOL
                                      . '<!--/*--><![CDATA[/*><!--*/' . PHP_EOL
                                      . implode(PHP_EOL . PHP_EOL, self::$snippets['javascript']) . PHP_EOL
                                      . '/*]]>*/-->' . PHP_EOL
                                      . '</script>' . PHP_EOL;
      }
      
    // Prepare snippets
      foreach (array_keys(self::$snippets) as $snippet) {
        if (is_array(self::$snippets[$snippet])) self::$snippets[$snippet] = implode(PHP_EOL, self::$snippets[$snippet]);
      }
    }
    
    public static function before_output() {
      
    // Get template settings
      self::$settings = unserialize(settings::get('store_template_catalog_settings'));
      
    // Clean orphan snippets
      $search = array(
        '/\{snippet:[^\}]+\}/',
        '/<!--snippet:[^-->]+-->/',
      );
      
      $GLOBALS['output'] = preg_replace($search, '', $GLOBALS['output']);
    }
    
    //public static function shutdown() {
    //}
    
    ######################################################################
    
    public static function expires($string=false) {
      if (strtotime($string) > time()) {
        header('Pragma:');
        header('Cache-Control: max-age='. (strtotime($string) - time()));
        header('Expires: '. date('r', strtotime($string)));
        self::$snippets['head_tags']['meta_expire'] = '<meta http-equiv="cache-control" content="public">' .PHP_EOL
                                                    . '<meta http-equiv="expires" content="'. date('r', strtotime($string)) .'">';
      } else {
        header('Cache-Control: no-cache');
        self::$snippets['head_tags']['meta_expire'] = '<meta http-equiv="cache-control" content="no-cache">' . PHP_EOL
                                                    . '<meta http-equiv="expires" content="'. date('r', strtotime($string)) .'">';
      }
    }
    
    public static function ilink($route=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      
      if ($route === null) {
        $route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($inherit_params === null) $inherit_params = true;
      } else {
        $route = WS_DIR_HTTP_HOME . $route;
      }
      
      return link::create_link($route, $new_params, $inherit_params, $skip_params, $language_code);
    }

    public static function href_ilink($route=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      return htmlspecialchars(self::ilink($route, $new_params, $inherit_params, $skip_params, $language_code));
    }
    
    public static function link($document=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      return link::create_link($document, $new_params, $inherit_params, $skip_params, $language_code);
    }

    public static function href_link($document=null, $new_params=array(), $inherit_params=null, $skip_params=array(), $language_code=null) {
      return htmlspecialchars(self::link($document, $new_params, $inherit_params, $skip_params, $language_code));
    }
  }
  
?>