<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once get_theme_file_path() . '/public/includes/class/class-base-answer.php';
class OE_answer extends OE_Base_answer
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
        if (isset($this->data['ans']) && $this->data['ans'] != null) {
            $this->ans = sanitize_text_field($this->data['ans']);
        } else {
            $this->ans = false;
        }
        if ($this->check_exam_status()) {
            $arr = [
                'res_text' => 'exam_finished',
                'exam_folder_id' => $this->data['exam_folder_id'],
            ];
            echo json_encode($arr);
            return;
        } else {
            $this->insert_single_answer();
        }
    }
    /**
     * @method is going to insert a answer performed by student each at a time
     * @return void
     */
    public function insert_single_answer()
    {
        if ($this->insert_answer(get_current_user_id(), $this->data['exam_folder_id'], $this->data['qustion_id'], $this->ans)) {
            if ($this->check_user_qus($this->data['exam_folder_id'], get_current_user_id())) {
                $arr = [
                    'res_text' => 'success',
                ];
                echo json_encode($arr);
            } else {
                $arr = [
                    'res_text' => 'qustion_finished',
                    'exam_folder_id' => $this->data['exam_folder_id'],
                ];
                echo json_encode($arr);
            }

        } else {
            echo 'failed';
        }
    }
    public function check_exam_status()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'question_folder';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . sanitize_text_field($this->data['exam_folder_id']) . " AND exam_status='Finished' AND terminate_exam=0");
        return $res;
    }
}
new OE_answer();
