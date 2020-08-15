<?php get_header('header.php');
class OE_previous_result
{
    private $exam_folder_data;
    public function __construct()
    {
        if (get_userdata(get_current_user_id())->roles[0] == 'student') {
            $this->exam_folder_table();
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
                           <tr role="row">
                                <td class="folder_icon">
                                    <a href="<?php echo site_url('/result-folder') ?>">
                                        <i class="fas fa-folder"></i>
                                    </a>
                                    <span>physics Exam</span>
                                </td>
                                <td>20</td>
                                <td>15</td>
                                <td class="attended">Attended</td>
                                <td class="pass_txt"><span>Passed</span></td>
                            </tr>
                           <tr role="row">
                                <td class="folder_icon">
                                    <a href="<?php echo site_url('/result-folder') ?>">
                                        <i class="fas fa-folder"></i>
                                    </a>
                                    <span>physics Exam</span>
                                </td>
                                <td>20</td>
                                <td>15</td>
                                <td class="absent">Absent</td>
                                <td class="fail_txt"><span>Failed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php

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