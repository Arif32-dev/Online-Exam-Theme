<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class Authentication
{
    private $post_data;
    public function __construct()
    {
        $this->post_data = $_POST;
        if ($this->post_data['action'] !== 'user_login') {
            echo 'Something went wrong';
            return;
        }
        $this->user_login();
    }
    public function user_login()
    {
        $cred = [
            'user_login' => $this->post_data['user'],
            'user_password' => $this->post_data['pass'],
            'remember' => true,
        ];
        $res = wp_signon($cred, true);
        if (!is_wp_error($res)) {
            $user_id = $res->data->ID;
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id, true);
            echo 'success';
        } else {
            if ($res->errors['incorrect_password'][0]) {
                echo 'Incorrect Password';
            }
            if ($res->errors['invalid_username'][0]) {
                echo 'Invalid username';
            }
            if ($res->errors['invalid_email'][0]) {
                echo 'Invalid email';
            }
        }
    }
}
new Authentication();
