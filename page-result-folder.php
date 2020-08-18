<?php
if (!is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
}
get_header('header.php');
require_once get_theme_file_path() . '/public/includes/class/class-base-result.php';

class OE_result_folder extends OE_Base_result
{
    private $exam_folder_id;
    private $exam_folder_data;
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
            if (isset($_GET['exam_folder_id']) && !empty($_GET['exam_folder_id'])) {
                $this->exam_folder_id = sanitize_text_field($_GET['exam_folder_id']);
                $this->exam_folder_data = $this->qustion_folder_check($this->exam_folder_id, 'Finished');
                if ($this->exam_folder_data) {
                    if (!$this->department_data($this->exam_folder_data)) {
                        return;
                    }
                    if ($this->check_perticipant($this->exam_folder_data)) {
                        $this->exam_folder_table();
                    } else {
                        $text = "Sorry. You havn't perticipated in exam";
                        $btn = "Previous Result's";
                        $url = site_url('/previous-result');
                        $this->notify_msg($text, $btn, $url);
                    }
                }
            } else {
                $text = "Please check previous exam results";
                $btn = "Previous Result's";
                $url = site_url('/previous-result');
                $this->notify_msg($text, $btn, $url);
            }
        } else {
            $text = "Sorry. But you are not a student to view result";
            $btn = "Back to Home";
            $url = site_url('/');
            $this->notify_msg($text, $btn, $url);
        }
    }
    public function exam_folder_table()
    {

        ?>
            <section class="exam_results">
                <h1>Exam Result</h1>
                <div class="current_result">

                    <div class="current_exam_info">
                        <div class="info">
                            <h3>Exam Name : <?php echo $this->exam_folder_data[0]->exam_folder_name ?></h3>
                            <h3>Department : <?php echo $this->department_data($this->exam_folder_data)[0]->dept_name ?></h3>
                        </div>
                        <div class="total_mark">
                            <h3>Total Mark : <?php echo $this->exam_folder_data[0]->total_mark ?></h3>
                            <h3>Your Mark : <?php echo $this->aquired_mark($this->exam_folder_data) ?></h3>
                        </div>
                    </div>

                    <div class="result">
                        <div class="header result_folder_page">
                            <span>Qustion</span>
                            <span>Correct Answer</span>
                            <span>Your Answer</span>
                            <span>Answer Status</span>
                        </div>
                        <div class="result_container">
                            <?php $this->student_result($this->exam_folder_id)?>
                        </div>
                    </div>

                </div>
            </section>
            <section class="result-sec">
                <a href="<?php echo site_url('/previous-result') ?>">Go Back</a>
            </section>
        <?php

    }
    public function result_loader($result, $exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qustions';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND qustion_id=" . $result->qustion_id . "");
        if (!$res) {
            return;
        }

        ?>
               <div class="show_result result_folder_page">
                        <div class="title">
                            <span>Qustion :</span>
                        </div>
                        <div class="qustion">
                            <p><?php echo stripslashes(stripslashes($res[0]->qustion)) ?></p>
                        </div>

                        <div class="title">
                            <span>Correct Answer :</span>
                        </div>
                        <div class="correct_ans">
                            <p><?php echo $this->correct_ans($res) ?></p>
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
                            <?php echo $this->answer_status($result, $res) ?>
                        </div>
                </div>
        <?php

    }
}
new OE_result_folder();

get_footer('footer.php')
?>