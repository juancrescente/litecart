<?php

  class ctrl_warehouse {
    public $data = array();
    
    public function __construct($warehouse_id=null) {
      if (!empty($warehouse_id)) {
        $this->load((int)$warehouse_id);
      } else {
        $this->reset();
      }
    }
    
    public function reset() {
      
      $this->data = array();
      
      $fields_query = database::query(
        "show fields from ". DB_TABLE_WAREHOUSES .";"
      );
      while ($field = database::fetch($fields_query)) {
        $this->data[$field['Field']] = '';
      }
    }
    
    public function load($warehouse_id) {
      $warehouses_query = database::query(
        "select * from ". DB_TABLE_WAREHOUSES ."
        where id='". (int)$warehouse_id ."'
        limit 1;"
      );
      $this->data = database::fetch($warehouses_query);
      if (empty($this->data)) trigger_error('Could not find warehouse (ID: '. (int)$warehouse_id .') in database.', E_USER_ERROR);
    }
    
    public function save() {
    
      if (empty($this->data['id'])) {
        database::query(
          "insert into ". DB_TABLE_WAREHOUSES ."
          (date_created)
          values ('". database::input(date('Y-m-d H:i:s')) ."');"
        );
        $this->data['id'] = database::insert_id();
        
        database::query(
          "alter table ". DB_TABLE_PRODUCTS_STOCK ."
          add `warehouse_". (int)$this->data['id'] ."` decimal(11, 4) not null;"
        );
      }
      
      database::query(
        "update ". DB_TABLE_WAREHOUSES ." set
        name = '". database::input($this->data['name']) ."',
        description = '". database::input($this->data['description'], true) ."',
        address = '". database::input($this->data['address']) ."',
        email = '". database::input($this->data['email']) ."',
        phone = '". database::input($this->data['phone']) ."',
        date_updated = '". date('Y-m-d H:i:s') ."'
        where id = '". (int)$this->data['id'] ."'
        limit 1;"
      );
      
      cache::clear_cache('warehouses');
    }
    
    public function delete() {
    
      if (empty($this->data['id'])) return;
      
      database::query(
        "alter table ". DB_TABLE_PRODUCTS_STOCK ."
        drop column `warehouse_". (int)$this->data['id'] ."`;"
      );
      
      database::query(
        "delete from ". DB_TABLE_WAREHOUSES ."
        where id = '". $this->data['id'] ."'
        limit 1;"
      );
      
      $this->data['id'] = null;
      
      cache::clear_cache('warehouses');
    }
  }

?>