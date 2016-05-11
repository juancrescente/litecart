<?php

  class notices {
    public static $data = array();


    public static function construct() {
    }

    public static function load_dependencies() {
      if (empty(session::$data['notices'])) {
        session::$data['notices'] = array(
          'errors' => array(),
          'warnings' => array(),
          'notices' => array(),
          'success' => array(),
        );
      }

      self::$data = &session::$data['notices'];
    }

    //public static function initiate() {
    //}

    //public static function startup() {
    //}

    //public static function before_capture() {
    //}

    //public static function after_capture() {
    //}

    public static function prepare_output() {

      $notices = array();

      if (!empty(array_filter(notices::$data))) {
        document::$snippets['notices'] = '<div id="notices">' . PHP_EOL;
        foreach (array_keys(notices::$data) as $type) {
          foreach (notices::$data[$type] as $notice) {
            switch ($type) {
              case 'errors':
                 document::$snippets['notices'] .= '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">×</a>' . functions::draw_fonticon('fa-exclamation-triangle') . ' ' . $notice .'</div>' . PHP_EOL;
                break;
              case 'warnings':
                 document::$snippets['notices'] .= '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">×</a>' . functions::draw_fonticon('fa-exclamation-triangle') . ' ' . $notice .'</div>' . PHP_EOL;
                break;
              case 'notices':
                 document::$snippets['notices'] .= '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">×</a>' . functions::draw_fonticon('fa-info-circle') . ' ' . $notice .'</div>' . PHP_EOL;
                break;
              case 'success':
                 document::$snippets['notices'] .= '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">×</a>' .functions::draw_fonticon('fa-check-circle') . ' ' . $notice .'</div>' . PHP_EOL;
                break;
            }
          }
        }
        document::$snippets['notices'] .= '</div>' . PHP_EOL
           . '<script>setTimeout(function(){$("#notices").slideUp();}, 25000);</script>';
      }

      self::reset();
    }

    public static function before_output() {
    }

    //public static function shutdown() {
    //}

    ######################################################################

    public static function reset($type=null) {

      if ($type) {
        self::$data[$type] = array();

      } else {
        if (!empty(self::$data)) {
          foreach (self::$data as $type => $container) {
            self::$data[$type] = array();
          }
        }
      }
    }

    public static function add($type, $msg, $key=false) {
      if ($key) self::$data[$type][$key] = $msg;
      else self::$data[$type][] = $msg;
    }

    public static function remove($type, $key) {
      unset(self::$data[$type][$key]);
    }

    public static function get($type) {
      if (!isset(self::$data[$type])) return false;
      return self::$data[$type];
    }

    public static function dump($type) {
      $stack = self::$data[$type];
      self::$data[$type] = array();
      return $stack;
    }
  }

?>