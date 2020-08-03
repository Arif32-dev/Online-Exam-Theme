<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class OE_profile
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
        if ($this->data) {
            if ($this->data['user_id'] || $this->data['user_name'] || $this->data['user_email'] || $this->data['user_pass'] || $this->data['con_pass']) {
                $this->update_user();
            } else {
                echo "One or more field is empty";
                return;
            }
        }
    }
    public function update_user()
    {
        if ($this->data['user_pass'] === $this->data['con_pass']) {
            $res = wp_update_user([
                'ID' => sanitize_text_field($this->data['user_id']),
                'display_name' => sanitize_text_field($this->data['user_name']),
                'user_pass' => sanitize_text_field($this->data['user_pass']),
            ]);
            if ($res) {
                $this->update_teacher();
            } else {
                echo 'Something went wrong';
            }
        } else {
            echo "Password didn't matched";
        }
    }
    public function update_teacher()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'teacher';
        $res = $wpdb->update(
            $table,
            [
                'teacher_name' => sanitize_text_field($this->data['user_name']),
            ],
            [
                'teacher_id' => get_current_user_id(),
            ],
            [
                '%s',
            ],
            [
                '%d',
            ]
        );
        $this->output($res);
    }
    public function output($res)
    {
        if ($res) {
            echo 'success';
        } else {
            echo "Something went wrong";
        }
    }
}
new OE_profile();
