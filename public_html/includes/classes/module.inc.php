<?php

  class module {
    public $type;
    public $modules;

    public function set_type($type) {
      $this->type = $type;
    }

    public function load($module_id='') {

      $modules_query = database::query(
        "select * from ". DB_TABLE_MODULES ."
        where type = '". database::input($this->type) ."'
        ". (!empty($module_id) ? "and module_id = '". database::input($module_id) ."'" : "") .";"
      );

      $modules = array();
      while($module = database::fetch($modules_query)){

      // Uninstall orphan modules
        if (!is_file(FS_DIR_HTTP_ROOT . WS_DIR_MODULES . $this->type . '/' . $module['module_id'] .'.inc.php')) {
          /*
          database::query(
            "delete from ". DB_TABLE_MODULES ."
            where module_id = '". database::input($module['id']) ."'
            limit 1;"
          );
          */
          continue;
        }

      // Decode settings
        $settings = json_decode($module['settings'], true);

      // Create object
        $object = new $module['module_id'];

      // Set settings to object
        $object->settings = array();
        foreach ($object->settings() as $setting) {
          $object->settings[$setting['key']] = isset($settings[$setting['key']]) ? $settings[$setting['key']] : $setting['default_value'];
        }

        $object->status = (isset($object->settings['status']) && in_array(strtolower($object->settings['status']), array('1', 'active', 'enabled', 'on', 'true', 'yes'))) ? 1 : 0;
        $object->priority = isset($object->settings[$setting['key']]) ? (int)$object->settings[$setting['key']] : 0;

        $this->modules[$object->id] = $object;
      }

    // Sort modules by priority
      if (!empty($this->modules)) {
        uasort($this->modules, function($a, $b) {
          if ((int)$a->priority == (int)$b->priority) {
            return ($a->name < $b->name) ? 1 : -1;
          } else if ((int)$a->priority > (int)$b->priority) {
            return 1;
          } else {
            return -1;
          }
        });
      }
    }
  }

?>