<?php

  class reference {
    private static $_cache;

    //public static function construct() {
    //}

    //public static function load_dependencies() {
    //}

    //public static function initiate() {
    //}

    //public static function startup() {
    //}

    //public static function before_capture() {
    //}

    //public static function after_capture() {
    //}

    //public static function prepare_output() {
    //}

    //public static function before_output() {
    //}

    //public static function shutdown() {
    //}

    ######################################################################

    public static function __callStatic($resource, $arguments) {

      if (empty($arguments[0])) {
        trigger_error('Passed argument cannot be empty', E_USER_WARNING);
        return;
      }

      if (isset(self::$_cache[$resource][$arguments[0]])) {
        return self::$_cache[$resource][$arguments[0]];
      }
      
      $component = null;
      if (preg_match('#^(ref|ctrl)_#', $resource, $matches)) {
        $component = $matches[1];
      }

      switch(true) {
        case ($component == 'ref'):
        case (!$component && file_exists(FS_DIR_HTTP_ROOT . WS_DIR_REFERENCES . 'ref_'.basename($resource).'.inc.php')):

          $class_name = 'ref_'.$resource;
          self::$_cache[$resource][$arguments[0]] = new $class_name($arguments[0]);
          return self::$_cache[$resource][$arguments[0]];

        case ($resource_type == 'ctrl'):
        case (!$component && file_exists(FS_DIR_HTTP_ROOT . WS_DIR_CONTROLLERS . 'ctrl_'.basename($resource).'.inc.php')):

          $class_name = 'ctrl_'.$resource;
          $object = new $class_name($arguments[0]);

          self::$_cache[$resource][$arguments[0]] = new StdClass;

          if (!empty($object->data['id'])) {
            foreach ($object->data as $key => $value) self::$_cache[$resource][$arguments[0]]->$key = $value;
          }

          return self::$_cache[$resource][$arguments[0]];

        default:

          self::$_cache[$resource][$arguments[0]] = null;
          trigger_error('Unsupported data object ('.$resource.')', E_USER_ERROR);
      }
    }
  }

?>