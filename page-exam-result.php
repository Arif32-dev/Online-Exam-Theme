<?php
if (!is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
}
get_header('header.php');
require_once get_theme_file_path() . '/public/includes/class/class-base-result.php';
class OE_current_exam_result extends OE_Base_result
{
    private $exam_folder_id;
    private $exam_folder_data;
    public function __construct()
    {

        if (get_userdata(get_current_user_id())->roles[0] == 'student') {
            if (isset($_GET['exam_folder_id']) && !empty($_GET['exam_folder_id'])) {
                $this->exam_folder_id = sanitize_text_field(escapeshellarg($_GET['exam_folder_id']));
                $this->exam_folder_data = $this->qustion_folder_check($this->exam_folder_id, 'Running');
                if ($this->exam_folder_data) {
                    if (!$this->department_data($this->exam_folder_data)) {
                        return;
                    }
                    if ($this->check_perticipant($this->exam_folder_data)) {
                        $this->fetch_result();
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
    public function fetch_result()
    {

        ?>
            <section class="exam_results">
                <h1>Exam Result</h1>
                <div class="current_result">

                    <div class="current_exam_info">
                        <div class="info">
                            <h3>Exam Name : <?php echo $this->exam_folder_data[0]->exam_folder_name ?></h3>
                            <h3>Department : <?php echo $this->department_data($this->exam_folder_data)[0]->dept_name; ?></h3>
                        </div>
                        <div class="total_mark">
                            <h3>Total Mark : <?php echo $this->exam_folder_data[0]->total_mark ?></h3>
                            <h3>Your Mark : <?php echo $this->aquired_mark($this->exam_folder_data) ?></h3>
                        </div>
                    </div>

                    <div class="result">
                        <div class="header">
                            <span>Qustion</span>
                            <span>Your Answer</span>
                            <span>Answer Status</span>
                        </div>
                        <div class="result_container">
                            <?php $this->student_result($this->exam_folder_id);?>
                        </div>
                    </div>

                </div>
            </section>
            <section class="result-sec">
                <a href="<?php echo site_url('/previous-result') ?>">Previous Results</a>
            </section>
        <?php

    }
}
new OE_current_exam_result();
get_footer('footer.php')
?>