<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class OE_qus_bulk_answer
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
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
        if ($res) {
            $this->update_qustion_folder($qus_data[0]['value']);
        }
    }
    public function update_qustion_folder(int $exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND status=1");
        if (!$res) {
            $table = $wpdb->prefix . 'question_folder';
            $check_qustion_number = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . "");
            if (!$check_qustion_number) {
                return;
            }
            $exam_folder_res = $wpdb->update(
                $table,
                [
                    'terminate_exam' => false,
                    'termination_date' => time(),
                    'exam_status' => 'Finished',
                ],
                [
                    'exam_folder_id' => sanitize_text_field($exam_folder_id),
                ],
                [
                    '%d',
                    '%d',
                    '%s',
                ],
                [
                    '%d',
                    '%d',
                ],
            );
            if ($exam_folder_res) {
                echo $exam_folder_id;
            }
        }
    }
}
new OE_qus_bulk_answer();
