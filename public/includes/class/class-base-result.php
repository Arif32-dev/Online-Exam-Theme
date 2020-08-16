<?php
class OE_Base_result
{
    public function student_result($exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND std_id=" . get_current_user_id() . "");
        if ($res) {
            foreach ($res as $result) {
                $this->result_loader($result, $exam_folder_id);
            }
        }
    }
    public function result_loader($result, $exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->get_results(
            "SELECT * FROM " . $table . "
                WHERE exam_folder_id=" . $exam_folder_id . " AND
                qustion_id=" . $result->qustion_id . "");
        if (!$res) {
            return;
        }

        ?>
                <div class="show_result">
                    <div class="title">
                        <span>Qustion :</span>
                    </div>
                    <div class="qustion">
                        <p><?php echo $res[0]->qustion ?></p>
                    </div>
                    <div class="title">
                        <span>Your Answer :</span>
                    </div>
                    <div class="std_answer">
                        <span><?php echo $this->student_answer($result, $res) ?></span>
                    </div>
                    <div class="title">
                        <span>Answer Status :</span>
                    </div>
                    <div class="answer_status">
                        <?php echo $this->answer_status($result, $res); ?>
                    </div>
                </div>
        <?php

    }
    public function correct_ans($res)
    {
        if ($res) {
            if ($res[0]->correct_ans == $res[0]->a1_id) {
                return $res[0]->a1;
            }
            if ($res[0]->correct_ans == $res[0]->a2_id) {
                return $res[0]->a2;
            }
            if ($res[0]->correct_ans == $res[0]->a3_id) {
                return $res[0]->a3;
            }
            if ($res[0]->correct_ans == $res[0]->a4_id) {
                return $res[0]->a4;
            }
        }
    }
    public function answer_status($result, $res)
    {
        if ($res) {
            if ($res[0]->correct_ans == $result->student_ans) {
                return '<span class="correct_ans">Correct</span>';
            } else {
                return '<span class="false_ans">Wrong</span>';
            }
        }
    }
    public function student_answer($result, $res)
    {
        if ($res) {
            if ($res[0]->a1_id == $result->student_ans) {
                return $res[0]->a1;
            }
            if ($res[0]->a2_id == $result->student_ans) {
                return $res[0]->a2;
            }
            if ($res[0]->a3_id == $result->student_ans) {
                return $res[0]->a3;
            }
            if ($res[0]->a4_id == $result->student_ans) {
                return $res[0]->a4;
            }
        }
    }
    public function aquired_mark($exam_folder_data)
    {
        $total_mark = 0;
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_data[0]->exam_folder_id . " AND std_id=" . get_current_user_id() . "");
        if ($res) {
            $table = $wpdb->prefix . 'qustions';
            foreach ($res as $result) {
                $qustion_res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_data[0]->exam_folder_id . " AND qustion_id=" . $result->qustion_id . "");
                if ($qustion_res) {
                    if ($result->student_ans == $qustion_res[0]->correct_ans) {
                        $total_mark += $exam_folder_data[0]->per_qus_mark;
                    }
                }
            }
        }
        return $total_mark;
    }
    public function check_perticipant($exam_folder_data)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->get_results("SELECT std_id FROM " . $table . " WHERE std_id=" . get_current_user_id() . " AND exam_folder_id=" . $exam_folder_data[0]->exam_folder_id . "");
        return $res;
    }
    public function department_data($exam_folder_data)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'department';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $exam_folder_data[0]->dept_id . "");
        return $res;
    }
    public function qustion_folder_check($exam_folder_id, $status)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'question_folder';
        $exam_folder_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND exam_status='$status' ORDER BY exam_folder_id DESC");
        return $exam_folder_data;
    }
    public function notify_msg($text, $btn, $url)
    {

        ?>
            <section class="oe-verifcation">
                <div class="veri_container">
                    <div class="ver_msg">
                        <p><?php echo $text ?></p>
                    </div>
                    <a href="<?php echo $url ?>"><?php echo $btn ?></a>
                </div>
            </section>
        <?php

    }
}