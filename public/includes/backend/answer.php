<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class OE_answer
{
    private $data;
    private $ans;
    public function __construct()
    {
        $this->data = $_POST;
        if (!$this->data['exam_folder_id'] || !$this->data['qustion_id']) {
            echo 'error';
            return;
        }
        if (isset($this->data['ans'])) {
            $this->ans = sanitize_text_field($this->data['ans']);
            $this->insert_answer();
        } else {
            $this->ans = false;
            $this->insert_answer();
        }
    }
    public function insert_answer()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->insert(
            $table,
            [
                'std_id' => get_current_user_id(),
                'exam_folder_id' => sanitize_text_field($this->data['exam_folder_id']),
                'qustion_id' => sanitize_text_field($this->data['qustion_id']),
                'student_ans' => $this->ans,
            ],
            [
                '%d',
                '%d',
                '%d',
                '%d',
            ]
        );
        if ($res) {
            $this->update_qustions();
        } else {
            echo 'failed';
        }
    }
    public function update_qustions()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->update(
            $table,
            [
                'status' => false,
            ],
            [
                'exam_folder_id' => sanitize_text_field($this->data['exam_folder_id']),
                'qustion_id' => sanitize_text_field($this->data['qustion_id']),
            ],
            [
                '%d',
            ],
            [
                '%d',
                '%d',
            ],
        );
        if ($res) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
new OE_answer();
