<?php 

namespace UserTestPlugin;

use UserTestPlugin\Database\UserDatabase;
use UserTestPlugin\Traits\Singleton;

class AjaxHandler {
    use Singleton;

    public function __construct() {
        add_action('wp_ajax_tusend_mail', [$this, 'sendMail']);
        add_action('wp_ajax_tuget_users', [$this, 'getUsers']);
        add_action('wp_ajax_tuadd_user', [$this, 'addUser']);
        add_action('wp_ajax_tuupdate_user', [$this, 'updateUser']);
        add_action('wp_ajax_tudelete_user', [$this, 'deleteUser']);

    }

    public function getUsers() {
        try {
            check_ajax_referer('usertest_ajax_nonce', '_ajax_nonce');
            
            error_log('getUsers ajax called');
            $users = UserDatabase::instance()->getUsers();
            wp_send_json_success($users);
        } catch (\Exception $e) {
            error_log('getUsers error: ' . $e->getMessage());
            wp_send_json_error('Failed to fetch users');
        }
    }

    public function addUser() {
        try {
            check_ajax_referer('usertest_ajax_nonce', '_ajax_nonce');
            
            $name = isset($_POST['data']['name']) ? sanitize_text_field($_POST['data']['name']) : '';
            $email = isset($_POST['data']['email']) ? sanitize_email($_POST['data']['email']) : '';
            
            error_log('addUser data received: Name - ' . $name . ', Email - ' . $email);

            if (empty($name) || empty($email)) {
                throw new \Exception('Both name and email are required.');
            }

            if (!is_email($email)) {
                throw new \Exception('Invalid email format');
            }

            UserDatabase::instance()->addUser($name, $email);
            wp_send_json_success('User added successfully');
        } catch (\Exception $e) {
            error_log('addUser error: ' . $e->getMessage());
            wp_send_json_error($e->getMessage());
        }
    }

    public function updateUser() {
        try {
            check_ajax_referer('usertest_ajax_nonce', '_ajax_nonce');
            
            $id = isset($_POST['data']['id']) ? intval($_POST['data']['id']) : 0;
            $name = isset($_POST['data']['name']) ? sanitize_text_field($_POST['data']['name']) : '';
            $email = isset($_POST['data']['email']) ? sanitize_email($_POST['data']['email']) : '';
            
            error_log('updateUser data received: ID - ' . $id . ', Name - ' . $name . ', Email - ' . $email);

            if (!$id || empty($name) || empty($email)) {
                throw new \Exception('Invalid data format');
            }

            if (!is_email($email)) {
                throw new \Exception('Invalid email format');
            }

            UserDatabase::instance()->updateUser($id, $name, $email);
            wp_send_json_success('User updated successfully');
        } catch (\Exception $e) {
            error_log('updateUser error: ' . $e->getMessage());
            wp_send_json_error($e->getMessage());
        }
    }

    public function deleteUser() {
        try {
            check_ajax_referer('usertest_ajax_nonce', '_ajax_nonce');
            
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            
            error_log('deleteUser data received: ID - ' . $id);

            if (!$id) {
                throw new \Exception('Invalid data format');
            }

            UserDatabase::instance()->deleteUser($id);
            wp_send_json_success('User deleted successfully');
        } catch (\Exception $e) {
            error_log('deleteUser error: ' . $e->getMessage());
            wp_send_json_error($e->getMessage());
        }
    }

    public function sendMail() {
        try {
            check_ajax_referer('usertest_ajax_nonce', '_ajax_nonce');
            error_log(print_r($_POST,true));

            $to_email = isset($_POST['data']['email']) ? sanitize_email($_POST['data']['email']) : '';
            $subject = isset($_POST['data']['subject']) ? sanitize_text_field($_POST['data']['subject']) : 'Default Subject';
            $message = isset($_POST['data']['message']) ? sanitize_textarea_field($_POST['data']['message']) : 'Default Message';

            if (empty($to_email) || !is_email($to_email)) {
                throw new \Exception('Invalid email address');
            }

            $headers = ['Content-Type: text/html; charset=UTF-8'];
            $mail_sent = wp_mail($to_email, $subject, $message, $headers);

            if (!$mail_sent) {
                throw new \Exception('Failed to send email');
            }

            wp_send_json_success(['message' => 'Mail sent successfully']);
        } catch (\Exception $e) {
            error_log('sendMail error: ' . $e->getMessage());
            wp_send_json_error(['error' => $e->getMessage()]);
        }
    }
}
