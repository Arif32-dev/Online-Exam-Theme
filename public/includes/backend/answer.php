<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
// require_once get_theme_file_path() . '/public/includes/class/class-base-answer.php';
class OE_answer
{
    private $data;
    private $ans;
    public function __construct()
    {
        $this->data = $_POST;
        if (!$this->data['exam_folder_id'] || !$this->data['qustion_id']) {
            $arr = [
                'res_text' => 'error',
            ];
            echo json_encode($arr);
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
            if ($this->check_exam_status($this->data['exam_folder_id'])) {
                $arr = [
                    'res_text' => 'success',
                ];
                echo json_encode($arr);
            } else {
                $this->update_qustion_folder($this->data['exam_folder_id']);
            }
        } else {
            $arr = [
                'res_text' => 'failed',
            ];
            echo json_encode($arr);
        }
    }
    public function update_qustion_folder(int $exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'question_folder';
        $check_qustion_number = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . "");
        if (!$check_qustion_number) {
            return;
        }
        $res = $wpdb->update(
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
        if ($res) {
            $arr = [
                'res_text' => 'exam_folder_update',
                'exam_folder_id' => $exam_folder_id,
            ];
            echo json_encode($arr);
        }
    }
    public function check_exam_status(int $exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND status=1");
        // if ($res) {
        //     return 'exists';
        // } else {
        //     return 'proceed';
        // }
        return $res;
    }
}
new OE_answer();
