<?php 

namespace UserTestPluginTest;
use UserTestPlugin\Database\UserDatabase;

class AjaxHandler {
    public function __construct() {
        add_action('wp_ajax_get_users', [$this, 'getUsers']);
        add_action('wp_ajax_add_user', [$this, 'addUser']);
        add_action('wp_ajax_update_user', [$this, 'updateUser']);
        add_action('wp_ajax_delete_user', [$this, 'deleteUser']);
    }

    public function getUsers() {
        $users = UserDatabase::instance()->getUsers();
        wp_send_json($users);
    }

    public function addUser() {
        $data = $_POST['data'];
        $name = sanitize_text_field($data['name']);
        $email = sanitize_email($data['email']);
        if (is_email($email)) {
            UserDatabase::instance()->addUser($name, $email);
            wp_send_json_success('User added.');
        } else {
            wp_send_json_error('Invalid email.');
        }
    }

    public function updateUser() {
        $data = $_POST['data'];
        $id = intval($data['id']);
        $name = sanitize_text_field($data['name']);
        $email = sanitize_email($data['email']);
        if (is_email($email)) {
            UserDatabase::instance()->updateUser($id, $name, $email);
            wp_send_json_success('User updated.');
        } else {
            wp_send_json_error('Invalid email.');
        }
    }

    public function deleteUser() {
        $id = intval($_POST['id']);
        UserDatabase::instance()->deleteUser($id);
        wp_send_json_success('User deleted.');
    }
}