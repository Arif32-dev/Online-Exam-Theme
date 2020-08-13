<?php
class OE_Base_answer
{
    /**
     * @method is going to insert answer in wp_result table
     * @param int $user_id, @param int $exam_folder_id, @param int $qustion_id, @param bool|int $student_ans
     * @return mixed|bool $res
     */
    public function insert_answer($user_id, $exam_folder_id, $qustion_id, $student_ans)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->insert(
            $table,
            [
                'std_id' => $user_id,
                'exam_folder_id' => sanitize_text_field($exam_folder_id),
                'qustion_id' => sanitize_text_field($qustion_id),
                'student_ans' => $student_ans,
            ],
            [
                '%d',
                '%d',
                '%d',
                '%d',
            ]
        );
        return $res;
    }

    /**
     * @method is going to update qustions folder  in wp_question_folder table
     * @param int $exam_folder_id
     * @return mixed|bool $res
     */
    public function update_qustion_folder(int $exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'question_folder';
        $check_exam_folder = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND exam_status='Finished'");
        if ($check_exam_folder) {
            return false;
        } else {
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
            return $res;
        }
    }

    /**
     * @method is going to check if all qustion is submitted or not if all it returns any response that means exam is not finished or if returns nothing or false that means exam is finished
     * @param int $exam_folder_id
     * @return mixed|bool $res
     */
    public function check_exam_status(int $exam_folder_id, int $user_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->get_results(
            "SELECT * FROM " . $table . "
                        WHERE exam_folder_id=" . $exam_folder_id . " AND
                            qustion_id NOT IN
                                ( SELECT qustion_id FROM wp_result WHERE
                                    exam_folder_id=" . $exam_folder_id . " AND
                                        std_id=" . $user_id . " ) ");
        return $res;
    }
}
