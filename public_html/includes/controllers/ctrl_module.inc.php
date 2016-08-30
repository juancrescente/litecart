<?php

  class ctrl_module {
    private $_module;
    public $data;

    public function __construct($module_id) {
      if (!empty($module_id)) {
        $this->load($module_id);
      } else {
        trigger_error('First argument module_id cannot be empty', E_USER_ERROR);
      }
    }

    public function reset() {

      $this->data = array();

      $fields_query = database::query(
        "show fields from ". DB_TABLE_MODULES .";"
      );
      while ($field = database::fetch($fields_query)) {
        $this->data[$field['Field']] = null;
      }
    }

    public function load($module_id) {

      $this->reset();

      preg_match('#^([^_]+)#', $module_id, $matches);

      switch ($matches[1]) {
        case 'cm':
          $this->_type = 'customer';
          break;
        case 'sm':
          $this->_type = 'shipping';
          break;
        case 'pm':
          $this->_type = 'payment';
          break;
        case 'om':
          $this->_type = 'order';
          break;
        case 'ot':
          $this->_type = 'order_total';
          break;
        case 'job':
          $this->_type = 'job';
          break;
        default:
          trigger_error('Unknown module type for module '. $module_id, E_USER_ERROR);
      }

      $modules_query = database::query(
        "select * from ". DB_TABLE_MODULES ."
        where type = '". database::input($this->_type) ."'
        and module_id = '". database::input($module_id) ."'
        limit 1;"
      );
      $module = database::fetch($modules_query);

      $this->data = array_replace($this->data, $module);

      $this->data['settings'] = $this->_decode_settings($this->data['settings']);

    // Module is installed
      if (!empty($module)) {
        $this->_module = new $module_id;

      // Decode settings
        $this->data['settings'] = json_decode($module['settings'], true);

        foreach ($this->_module->settings() as $structure) {
          if (!isset($this->data['settings'][$structure['key']])) $this->data['settings'][$structure['key']] = $structure['default_value'];
        }
      }
    }

    public function save() {

      if (empty($this->data['id'])) {

        database::query(
          "insert into ". DB_TABLE_MODULES ."
          (module_id, date_created)
          values ('". database::input($this->data['module_id']) ."', '". date('Y-m-d H:i:s') ."');"
        );

        $this->data['id'] = database::insert_id();

        if (method_exists($this->_module, 'uninstall')) {
          $this->_module->uninstall();
        }

        if (method_exists($this->_module, 'install')) {
          $this->_module->install();
        }

      } else {

        if (method_exists($this->_module, 'update')) {
          $this->_module->update();
        }
      }

      database::query(
        "update ". DB_TABLE_MODULES ."
        set
          module_id = '". database::input($this->data['module_id']) ."',
          type = '". database::input($this->data['type']) ."',
          status = '". (int)$this->data['status'] ."',
          priority = '". (int)$this->data['priority'] ."',
          settings = '". database::input($this->_encode_settings($this->data['settings'])) ."',
          date_updated = '". date('Y-m-d H:i:s') ."'
        where id = '". (int)database::input($this->data['id']) ."'
        limit 1;"
      );

      cache::clear_cache('modules');
    }

    public function delete() {

      if (method_exists($this->_module, 'uninstall')) {
        $this->_module->uninstall();
      }

      database::query(
        "delete from ". DB_TABLE_MODULES ."
        where module_id = '". database::input($this->data['module_id']) ."'
        limit 1;"
      );

      cache::clear_cache('modules');
    }

    private function _encode_settings($data) {

      mb_convert_variables('UTF-8', language::$selected['charset'], $data);

      return json_encode($data);
    }

    private function _decode_settings($data) {

      $data = json_decode($data, true);

      mb_convert_variables(language::$selected['charset'], 'UTF-8', $data);

      return $data;
    }
  }

?>