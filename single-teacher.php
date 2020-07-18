<?php get_header('header.php')?>
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <section class="single_post">
          <?php

        if (get_the_post_thumbnail_url()) {

            ?>
             <div class="img_wrap">
                <img src=" <?php echo get_the_post_thumbnail_url() ?>" alt="">
            </div>
            <?php

        } else {

            ?>
            <div class="img_wrap avater_wrap">
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" alt="">
            </div>
            <?php

        }

        ?>
            <h1><?php echo get_the_title() ?></h1>
            <?php

        if (get_the_content()) {

            ?>
                     <div class="desc">
                        <p>
                            <?php echo get_the_content() ?>
                        </p>
                    </div>
                    <?php

        }

        global $wpdb;
        $table = $wpdb->prefix . 'teacher';
        $teacher_data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE teacher_id=" . get_the_ID() . " ");

        $table = $wpdb->prefix . 'department';
        $dept_data = $wpdb->get_results("SELECT dept_name FROM " . $table . " WHERE dept_id=" . $teacher_data[0]->teacher_dept . "");

        ?>

           <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong><?php echo $teacher_data[0]->teacher_name ?></span>
                    <span><strong>Department :</strong><?php echo $dept_data[0]->dept_name ?></span>
                    <span><strong>Phone :</strong><?php echo $teacher_data[0]->teacher_phn ?></span>
                </div>
            </div>
        </section>
    <?php

    }
}
?>
<?php get_footer('footer.php')?>
