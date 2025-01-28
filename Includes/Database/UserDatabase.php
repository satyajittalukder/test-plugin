<?php

namespace UserTestPlugin\Database;

use UserTestPlugin\Traits\Singleton;

class UserDatabase
{
    use Singleton;

    private $table_name;

    public function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'user_test'; // Define your table name
    }

    public function createTable()
    {
        global $wpdb;

        // Check if the table exists
        if ($this->tableExists()) {
            error_log('Table already exists, skipping creation.');
            return; // Skip if the table already exists
        }

        // SQL to create the table
        $charset_collate = $wpdb->get_charset_collate();
       
        $sql = "CREATE TABLE {$this->table_name} (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        // Execute the SQL to create the table
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
        
        error_log('Table created successfully.');
    }


    public function addUser($name, $email) {
        global $wpdb;
        $wpdb->insert($this->table_name, compact('name', 'email'));
    }

    public function getUsers() {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$this->table_name}");
    }

    public function updateUser($id, $name, $email) {
        global $wpdb;
        $wpdb->update($this->table_name, compact('name', 'email'), ['id' => $id]);
    }

    public function deleteUser($id) {
        global $wpdb;
        $wpdb->delete($this->table_name, ['id' => $id]);
    }

    // Check if the table exists
    private function tableExists()
    {
        global $wpdb;
        $result = $wpdb->get_var("SHOW TABLES LIKE '{$this->table_name}'");
        return !empty($result);
    }
}
