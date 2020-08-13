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
        if (isset($this->data['ans'])) {
            $this->ans = sanitize_text_field($this->data['ans']);
            $this->insert_single_answer();
        } else {
            $this->ans = false;
            $this->insert_single_answer();
        }
    }
    /**
     * @method is going to insert a answer performed by student each at a time
     * @return void
     */
    public function insert_single_answer()
    {
        /* if the method return true then update qustion */
        if ($this->insert_answer(get_current_user_id(), $this->data['exam_folder_id'], $this->data['qustion_id'], $this->ans)) {
            /* if all answer is not submitted then just output message */
            if ($this->check_exam_status($this->data['exam_folder_id'], get_current_user_id())) {
                $arr = [
                    'res_text' => 'success',
                ];
                echo json_encode($arr);
            } else {
                $arr = [
                    'res_text' => 'exam_folder_update',
                    'exam_folder_id' => $this->data['exam_folder_id'],
                ];
                echo json_encode($arr);
            }

        } else {
            echo 'failed';
        }
    }
}
new OE_answer();
