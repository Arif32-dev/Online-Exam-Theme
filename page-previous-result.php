<?php
if (!is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
}
get_header('header.php');
class OE_previous_result
{
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
            if ($this->qustion_folder_check()) {
                $this->exam_folder_table();
            }
        } else {
            $text = "Sorry. But you are not a student to view result";
            $btn = "Back to Home";
            $url = site_url('/');
            $this->notify_msg($text, $btn, $url);
        }
    }
    public function qustion_folder_check()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'question_folder';
        $this->exam_folder_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_status='Finished' ORDER BY exam_folder_id DESC");
        return $this->exam_folder_data;
    }
    public function exam_folder_table()
    {

        ?>
            <section class="exam_results">
                <h1>Previous Result's</h1>
                <div class="table_container">
                    <table role="table">
                        <thead role="rowgroup">
                            <tr role="row">
                                <th>Exam Name</th>
                                <th>Full Mark</th>
                                <th>Your Mark</th>
                                <th>Attendence</th>
                                <th>Exam Status</th>
                            </tr>
                        </thead>
                        <tbody role="rowgroup">
                            <?php $this->table_rows()?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php

    }
    public function table_rows()
    {
        if ($this->exam_folder_data) {
            foreach ($this->exam_folder_data as $exam_data) {

                ?>
                    <tr role="row">
                        <td class="folder_icon">
                            <a href="<?php echo site_url('/result-folder?exam_folder_id=' . $exam_data->exam_folder_id . '') ?>">
                                <i class="fas fa-folder"></i>
                            </a>
                            <span><?php echo $exam_data->exam_folder_name ?></span>
                        </td>
                        <td><?php echo $exam_data->total_mark ?></td>
                        <td><?php echo $this->aquired_mark($exam_data->exam_folder_id, $exam_data->per_qus_mark); ?></td>
                        <?php echo $this->exam_attendence($exam_data->exam_folder_id); ?>
                        <?php echo $this->exam_status($exam_data->exam_folder_id, $exam_data->per_qus_mark, $exam_data->pass_percentage, $exam_data->total_mark); ?>
                    </tr>
                <?php

            }
        }
    }
    public function aquired_mark($exam_folder_id, $per_qus_mark)
    {
        $total_mark = 0;
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND std_id=" . get_current_user_id() . "");
        if ($res) {
            $table = $wpdb->prefix . 'qustions';
            foreach ($res as $result) {
                $qustion_res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND qustion_id=" . $result->qustion_id . "");
                if ($qustion_res) {
                    if ($result->student_ans == $qustion_res[0]->correct_ans) {
                        $total_mark += $per_qus_mark;
                    }
                }
            }
        }
        return $total_mark;
    }
    public function exam_status($exam_folder_id, $per_qus_mark, $pass_percentage, $total_mark)
    {
        $pass_mark = $total_mark * ($pass_percentage / 100);
        if (ceil($this->aquired_mark($exam_folder_id, $per_qus_mark)) >= ceil($pass_mark)) {
            return '<td class="pass_txt"><span>Passed</span></td>';
        } else {
            return '<td class="fail_txt"><span>Failed</span></td>';
        }
    }
    public function exam_attendence($exam_folder_id)
    {
        global $wpdb;
        $table = $wpdb->prefix . 'result';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_folder_id=" . $exam_folder_id . " AND std_id=" . get_current_user_id() . "");
        if ($res) {
            return '<td class="attended">Attended</td>';
        } else {
            return '<td class="absent">Absent</td>';
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
new OE_previous_result();
get_footer('footer.php')?>