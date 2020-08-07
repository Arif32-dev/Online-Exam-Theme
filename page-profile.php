<?php
if (!is_user_logged_in() && get_userdata(get_current_user_id())->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
}
get_header('header.php')?>
<section class="oe-profile">
    <div class="profile_wrap">
        <div class="profile_img">
            <img src="<?php echo get_template_directory_uri() . '/public/assets/img/user.png' ?>" alt="User Profile" title="<?php echo get_userdata(get_current_user_id())->data->display_name; ?>">
        </div>
        <div class="user_info">
            <form action="" id="oe_user_profile" method="post">
                <div class="warning_text"></div>
                <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
                <div class="inp_wrap">
                    <label for="name">Name :</label>
                    <input type="text" required name="user_name" value="<?php echo esc_attr(get_userdata(get_current_user_id())->data->display_name); ?>">
                </div>
                <div class="inp_wrap">
                    <label for="name">Email :</label>
                    <input type="text" disabled name="user_email" value="<?php echo esc_attr(get_userdata(get_current_user_id())->data->user_email); ?>">
                </div>
                    <?php get_userdata(get_current_user_id())->roles[0] == 'administrator' ? "" : select_box()?>
                <div id="old_pass" class="inp_wrap">
                    <label for="name">New Password :</label>
                    <input type="password" required name="user_pass">
                </div>
                <div id="con_pass" class="inp_wrap">
                    <label for="name">Confirm Password :</label>
                    <input type="password" required name="con_pass">
                 </div>
                <button type="sumbit">Update Profle</button>
            </form>
        </div>
    </div>
</section>
<?php
function select_box()
{

    ?>
         <div class="inp_wrap">
                <label for="name">Department :</label>
                <div class="select_box">
                    <select name="dept" form="oe_user_profile" >
                        <?php get_department();?>
                    </select>
                </div>
        </div>
    <?php

}
function get_department()
{
    global $wpdb;
    if (get_userdata(get_current_user_id())->roles[0] == 'teacher') {
        $teacher_table = $wpdb->prefix . 'teacher';
        $teacher_data = $wpdb->get_results("SELECT * FROM " . $teacher_table . " WHERE teacher_id=" . get_current_user_id() . "");
        if ($teacher_data) {
            $table = $wpdb->prefix . 'department';
            $dept_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $teacher_data[0]->teacher_dept . "");

            if ($dept_data) {

                ?>
                    <option disabled value="" <?php echo $dept_data[0]->dept_id == $teacher_data[0]->teacher_dept ? "selected" : "" ?>><?php echo $dept_data[0]->dept_name ?></option>
                <?php

            } else {

                ?>
                    <option value="" selected disabled>No Department</option>
                <?php

            }

        }
    }
    if (get_userdata(get_current_user_id())->roles[0] == 'student') {
        $std_table = $wpdb->prefix . 'students';
        $std_data = $wpdb->get_results("SELECT * FROM " . $std_table . " WHERE std_id=" . get_current_user_id() . "");
        if ($std_data) {
            $table = $wpdb->prefix . 'department';
            $dept_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE dept_id=" . $std_data[0]->dept_id . "");
            if ($dept_data) {

                ?>
                        <option disabled value="" <?php echo $dept_data[0]->dept_id == $std_data[0]->dept_id ? "selected" : "" ?>><?php echo $dept_data[0]->dept_name ?></option>
                <?php

            } else {

                ?>
                    <option value="" selected disabled>No Department</option>
                <?php

            }

        }

    }
}
?>

<?php get_footer('footer.php')?>
