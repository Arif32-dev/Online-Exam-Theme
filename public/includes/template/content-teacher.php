<?php
global $wpdb;
$table = $wpdb->prefix . 'teacher';
$teacher_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE teacher_id=" . get_the_ID() . " ");
if($teacher_data){

    foreach ($teacher_data as $teacher) {
        $table = $wpdb->prefix . 'department';
        $dept_data = $wpdb->get_results("SELECT dept_name FROM " . $table . " WHERE dept_id=" . $teacher->teacher_dept . "");
        
        ?>
      <div class="teacher_info">
                <div class="side_logo">
                    <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
                </div>
                <div class="teacher_details">
                    <div class="row">
                        <span><strong>Name :</strong><?php echo $teacher->teacher_name ?></span>
                        <span><strong>Department :</strong><?php echo $dept_data[0]->dept_name ?></span>
                        <span><strong>Phone :</strong><?php echo $teacher->teacher_phn ?></span>
                    </div>
                    <a href="<?php echo get_the_permalink() ?> ">View Teacher</a>
                </div>
    </div>
      <?php

    }
}