<?php get_header('header.php');
function prev_routine()
{
    global $wpdb;
    $table = $wpdb->prefix . 'exam_routine';
    $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_date <= CURDATE() ");
    if ($res) {
        foreach ($res as $notice) {
            $table = $wpdb->prefix . 'department';
            $dept_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $notice->dept_id . "");
            if ($dept_data) {

                ?>
                <div class="routine_detail_con">
                        <div>
                            <h3>Department : <?php echo $dept_data[0]->dept_name ?></h3>
                            <h3>Exam Name : <?php echo $notice->exam_name ?></h3>
                            <span><strong>Date :</strong><?php echo date_format(date_create($notice->exam_date), "d-M-Y") ?></span>
                        </div>
                </div>
                <?php

            }

        }
    }
}
?>
<section class="prev_routine">
    <h1>Previous Routine's</h1>
    <div class="prev_exam_container">
           <?php prev_routine()?>
    </div>
    <section class="result-sec">
        <a href="<?php echo site_url('/') ?>">Back To Home</a>
    </section>
</section>
<?php get_footer('footer.php')?>