<?php get_header('header.php');
class OE_front_page
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
        $this->banner_sec();
        $this->dept_sec();
        $this->teacher_sec();
        $this->notice_sec();
        $this->map_sec();
    }
    public function banner_sec()
    {
        ?>
          <div class="banner">
                <div class="overlay"></div>
                <div class="info">
                    <h1>Online Exam</h1>
                    <h2>A place where you can test yourself</h2>
                    <a href="<?php echo site_url('/blog') ?> ">Read More</a>
                </div>
        </div>
        <?php

    }
    public function dept_sec()
    {
        ?>
        <section class='dept_wrap'>
                <h1>Our Departments</h1>
                <div class="department">
                        <?php require get_template_directory() . '/public/includes/template/content-department.php'?>
                </div>
        </section>
        <?php

    }
    public function teacher_sec()
    {
        ?>
            <section class="teacher-wrap">
                <h1>Our Teacher's</h1>
                <div class="teacher_container">
                    <?php $this->all_teacher()?>
                </div>
            </section>
        <?php

    }
    public function teacher_data()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'teacher';
        $teacher_data = $wpdb->get_results("SELECT * FROM " . $table . "");
        return $teacher_data;
    }
    public function all_teacher()
    {
        global $wpdb;
        $teacher_data = $this->teacher_data();
        if ($teacher_data) {
            foreach ($teacher_data as $teacher) {
                $table = $wpdb->prefix . 'department';
                $dept_data = $wpdb->get_results("SELECT dept_name FROM " . $table . " WHERE dept_id=" . $teacher->teacher_dept . "");
                if ($dept_data) {
                    $this->teacher_html($teacher, $dept_data);
                }
            }
        }
    }
    public function teacher_html($teacher, $dept_data)
    {

        ?>
            <div class="teacher_info">
                <div class="side_logo">
                    <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
                </div>
                <div class="teacher_details">
                    <div class="row">
                        <span><strong>Name :</strong><?php echo $teacher->teacher_name ?></span>
                        <span><strong>Department :</strong><?php echo $dept_data[0]->dept_name ?></span>
                        <span><strong>Phone :</strong><?php echo $this->teacher_phn_availablity($teacher) ?></span>
                    </div>
                </div>
            </div>
        <?php

    }
    public function teacher_phn_availablity($teacher)
    {
        if (is_user_logged_in()) {
            return $teacher->teacher_phn;
        } else {
            return 'Please Log in to view phone';
        }
    }

    public function notice_sec()
    {

        ?>
            <section class="notice">
                <h1>Notice Board</h1>
                <div class="notice_container">
                    <div class="upcoming">
                        <h2>Upcoming Exam's</h2>
                            <?php $this->upcoming_notice()?>
                    </div>
                    <div class="previous">
                        <h2>Previous Exam's</h2>
                        <?php $this->previous_notice()?>
                        <?php $this->view_btn()?>
                     </div>
                </div>
            </section>
        <?php

    }
    public function upcoming_notice()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'exam_routine';
        $notices = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_date > CURDATE()");
        if (!$notices) {
            return;
        }
        foreach ($notices as $notice) {
            $table = $wpdb->prefix . 'department';
            $dept_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $notice->dept_id . "");

            ?>
                <div >
                    <h3>Department : <?php echo $dept_data[0]->dept_name ?></h3>
                    <h3>Exam Name : <?php echo $notice->exam_name ?></h3>
                    <span><strong>Date :</strong><?php echo date_format(date_create($notice->exam_date), "d-M-Y") ?></span>
                </div>
            <?php

        }
    }
    public function previous_notice()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'exam_routine';
        $notices = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_date <= CURDATE() LIMIT 3");
        if (!$notices) {
            return;
        }
        foreach ($notices as $notice) {
            $table = $wpdb->prefix . 'department';
            $dept_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $notice->dept_id . "");
            if ($dept_data) {

                ?>
                <div>
                    <h3>Department : <?php echo $dept_data[0]->dept_name ?></h3>
                    <h3>Exam Name : <?php echo $notice->exam_name ?></h3>
                    <span><strong>Date :</strong><?php echo date_format(date_create($notice->exam_date), "d-M-Y") ?></span>
                </div>
            <?php

            }

        }
    }
    public function view_btn()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'exam_routine';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE exam_date <= CURDATE() LIMIT 99 OFFSET 3");
        if (!$res) {
            return;
        }

        ?>
             <a class="view_all" href="<?php echo site_url('/previous-routine') ?>">View all</a>
        <?php

    }
    public function map_sec()
    {

        ?>
            <section class="oe_google_map">
                <h1>Our Location</h1>
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe  id="gmap_canvas" src="https://maps.google.com/maps?q=university%20of%20san%20francisco&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    </div>
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
new OE_front_page();
get_footer('footer.php');