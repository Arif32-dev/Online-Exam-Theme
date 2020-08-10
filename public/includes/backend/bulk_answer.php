<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class OE_answer
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
        // print_r($this->data['final_data']);
        if (!$this->data['final_data']) {
            return;
        }
        foreach ($this->data['final_data'] as $key) {
            if (!$key) {
                return;
            }
            $this->insert_answer($key);
        }
    }
    public function insert_answer(array $qus_data)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->insert(
            $table,
            [
                'std_id' => get_current_user_id(),
                'exam_folder_id' => sanitize_text_field($qus_data[0]['value']),
                'qustion_id' => sanitize_text_field($qus_data[1]['value']),
                'student_ans' => false,
            ],
            [
                '%d',
                '%d',
                '%d',
                '%d',
            ]
        );
        if ($res) {
            $this->update_qustions($qus_data);
        } else {
            echo 'failed';
        }
    }
    public function update_qustions(array $qus_data)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->update(
            $table,
            [
                'status' => false,
            ],
            [
                'exam_folder_id' => sanitize_text_field($qus_data[0]['value']),
                'qustion_id' => sanitize_text_field($qus_data[1]['value']),
            ],
            [
                '%d',
            ],
            [
                '%d',
                '%d',
            ],
        );
    }
}
new OE_answer();
