<?php
if (!is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
}
get_header('header.php');
class OE_department_exam
{
    public function __construct()
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        if (!function_exists('is_plugin_active') || !is_plugin_active('online-exam/online-exam.php')) {
            $text = "This theme require Online Exam Plugin to work properly";
            $btn = "Activate Plugin";
            $url = admin_url('plugins.php');
            $this->notify_msg($text, $btn, $url);
            return;
        }
        if (get_userdata(get_current_user_id())->roles[0] == 'student') {
            $this->fetch_qustion();
        } else {
            $text = "Sorry . But you are not a student to perform an exam";
            $btn = "Back to Home";
            $url = site_url('/');
            $this->notify_msg($text, $btn, $url);
        }
    }
    public function fetch_qustion()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'students';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE std_id=" . get_current_user_id() . "");
        if ($res) {
            $table = $wpdb->prefix . 'question_folder';
            $exam_folder_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $res[0]->dept_id . " AND publish_exam=1 AND exam_status='Running'");

            if ($exam_folder_data) {
                $table = $wpdb->prefix . 'qustions';
                $result_table = $wpdb->prefix . 'result';
                $qustion_data = $wpdb->get_results(
                    "SELECT * FROM " . $table . "
                        WHERE exam_folder_id=" . $exam_folder_data[0]->exam_folder_id . " AND
                            qustion_id NOT IN
                                ( SELECT qustion_id FROM `{$result_table}` WHERE
                                    exam_folder_id=" . $exam_folder_data[0]->exam_folder_id . " AND
                                        std_id=" . get_current_user_id() . " ) ");

                if ($qustion_data) {
                    if (time() > $exam_folder_data[0]->remaining_time) {

                        ?>
                        <section class="result-sec">
                            <a href="<?php echo site_url('/exam-result?exam_folder_id=' . $exam_folder_data[0]->exam_folder_id . '') ?>">View Result</a>
                        </section>
                        <?php

                    } else {
                        $this->exam_timer($exam_folder_data);
                        $this->exam_qustions($qustion_data);
                    }
                } else {

                    ?>
                        <section class="result-sec">
                            <a href="<?php echo site_url('/exam-result?exam_folder_id=' . $exam_folder_data[0]->exam_folder_id . '') ?>">View Result</a>
                        </section>
                    <?php

                }
            } else {
                $text = "No exam is published yet";
                $btn = "Previous Exam's";
                $url = site_url('/previous-result');
                $this->notify_msg($text, $btn, $url);
            }
        }
    }
    public function exam_qustions($qustion_data)
    {

        ?>
                <div class="qus-container">
                    <div class="qus_wrap">
                        <?php $this->qustion_cards($qustion_data)?>
                    </div>
                </div>
        <?php

    }
    public function qustion_cards($qustion_data)
    {
        foreach ($qustion_data as $qustion) {

            ?>
                 <div class="qus_card">
                            <div class="qustion">
                                <p>
                                    <?php echo sanitize_text_field(trim($qustion->qustion)) ?>
                                </p>
                            </div>
                            <form class="oe_mcq">
                                <input type="hidden" name="exam_folder_id" value="<?php echo $qustion->exam_folder_id ?>">
                                <input type="hidden" name="qustion_id" value="<?php echo sanitize_text_field(trim($qustion->qustion_id)) ?>">
                                <div class="ans">
                                    <div class="ans_box">
                                        <input type="radio" name="ans" value="<?php echo sanitize_text_field(trim($qustion->a1_id)) ?>">
                                        <p><?php echo sanitize_text_field(trim($qustion->a1)) ?></p>
                                    </div>
                                    <div class="ans_box">
                                        <input type="radio" name="ans" value="<?php echo sanitize_text_field(trim($qustion->a2_id)) ?>">
                                        <p><?php echo sanitize_text_field(trim($qustion->a2)) ?></p>
                                    </div>
                                    <div class="ans_box">
                                        <input type="radio" name="ans" value="<?php echo sanitize_text_field(trim($qustion->a3_id)) ?>">
                                        <p><?php echo sanitize_text_field(trim($qustion->a3)) ?></p>
                                    </div>
                                    <div class="ans_box">
                                        <input type="radio" name="ans" value="<?php echo sanitize_text_field(trim($qustion->a4_id)) ?>">
                                        <p><?php echo sanitize_text_field(trim($qustion->a4)) ?></p>
                                    </div>
                                </div>
                                <input type="submit" name="sumbit_ans" value="Answer">
                            </form>
                 </div>
            <?php

        }
    }
    public function exam_timer($exam_folder_data)
    {
        $zoneList = timezone_identifiers_list();
        if (in_array(wp_timezone_string(), $zoneList)) {
            date_default_timezone_set(wp_timezone_string());
        } else {
            date_default_timezone_set('America/Los_Angeles');
        }

        ?>
            <section class="oe_timer">
                <div class="time_wrap">
                    <div class="exam_details">
                        <h3>Department : <?php $this->get_department($exam_folder_data)?></h3>
                        <h3>Exam Name : <?php echo trim($exam_folder_data[0]->exam_folder_name) ?></h3>
                        <h3>Total Mark : <?php echo trim($exam_folder_data[0]->total_mark) ?></h3>
                    </div>
                    <span data-remaining_time="<?php echo date("M d, Y H:i:s", $exam_folder_data[0]->remaining_time) ?>" id="oe_timer"></span>
                </div>
            </section>
        <?php

    }
    public function get_department($exam_folder_data)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'department';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $exam_folder_data[0]->dept_id . "");
        if ($res) {
            echo $res[0]->dept_name;
        }
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
new OE_department_exam();

get_footer('footer.php')
?>