<?php get_header('header.php');

class Single_teacher
{
    private $table;
    private $teacher_data;
    private $dept_data;
    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix . 'teacher';
        $this->teacher_data = $wpdb->get_results("SELECT * FROM " . $this->table . " WHERE teacher_id=" . get_the_ID() . " ");

        $this->table = $wpdb->prefix . 'department';
        $this->dept_data = $wpdb->get_results("SELECT dept_name FROM " . $this->table . " WHERE dept_id=" . $this->teacher_data[0]->teacher_dept . "");
        $this->single_post();
    }
    public function single_post()
    {
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                ?>
                    <section class="single_teacher">
                        <?php $this->img_sec();?>
                        <h1><?php echo get_the_title(); ?></h1>
                        <?php $this->content_sec();?>
                        <?php $this->details_sec();?>
                    </section>
            <?php

            }
        }
    }
    public function img_sec()
    {
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
    }
    public function content_sec()
    {

        if (get_the_content()) {

            ?>
                <div class="desc">
                    <p>
                        <?php echo get_the_content() ?>
                    </p>
                </div>
            <?php

        }
    }
    public function details_sec()
    {

        ?>
            <div class="teacher_details">
                <div class="row">
                    <span><strong>Name :</strong><?php echo $this->teacher_data[0]->teacher_name ?></span>
                    <span><strong>Department :</strong><?php echo $this->dept_data[0]->dept_name ?></span>
                    <span><strong>Phone :</strong><?php echo $this->teacher_data[0]->teacher_phn ?></span>
                </div>
            </div>
        <?php

    }
}
new Single_teacher();
get_footer('footer.php')
?>
