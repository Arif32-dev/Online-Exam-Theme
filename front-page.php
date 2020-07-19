<?php get_header('header.php');
class OE_front_page
{
    public function __construct()
    {
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
                    <h1>Gurudayal University</h1>
                    <h2>A dream university to read</h2>
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
        $teacher = $this->teacher_query();
        ?>
            <section class="teacher-wrap">
                <h1>Our Teacher's</h1>
                <div class="teacher_container">
                    <?php $this->teacher_loop($teacher);?>
                </div>
                <div class="oe-pagination">
                    <span class="pagination_wrap">
                        <?php $this->paginate_teacher($teacher)?>
                    </span>
                </div>
            </section>
        <?php

    }
    public function teacher_query()
    {
        $teacher = new WP_Query(
            [
                'post_type' => 'teacher',
                'posts_per_page' => 4,
                'paged' => get_query_var('page'),
            ]
        );
        return $teacher;
    }

    public function teacher_loop($teacher)
    {
        if ($teacher->have_posts()) {
            while ($teacher->have_posts()) {
                $teacher->the_post();
                get_template_part('./public/includes/template/content', 'teacher');
            }
            wp_reset_postdata();
        }

    }
    public function paginate_teacher($teacher)
    {
        echo paginate_links(
            [
                'current' => max(1, get_query_var('page')),
                'prev_text' => 'Prev',
                'next_text' => 'Next',
                'total' => $teacher->max_num_pages,
            ]
        );

    }
    public function notice_sec()
    {

        ?>
            <section class="notice">
                <h1>Notice Board</h1>
                <div class="notice_container">
                    <div href="http://www.facebook.com" class="upcoming">
                        <h2>Upcoming Exam's</h2>
                        <a href="http://www.facebook.com">
                            <h3>Department : Biology</h3>
                            <h3>Exam Name : Biology Exam</h3>
                            <span><strong>Date :</strong>10/07/2020</span>
                        </a>
                    </div>
                    <div class="previous">
                        <h2>Previous Exam's</h2>
                        <a>
                            <h3>Department : Mathmatics</h3>
                            <h3>Exam Name : Math Exam</h3>
                            <span><strong>Date :</strong>10/07/2020</span>
                        </a>
                        <a>
                            <h3>Department : Mathmatics</h3>
                            <h3>Exam Name : Math Exam</h3>
                            <span><strong>Date :</strong>10/07/2020</span>
                        </a>
                        <a>
                            <h3>Department : Mathmatics</h3>
                            <h3>Exam Name : Math Exam</h3>
                            <span><strong>Date :</strong>10/07/2020</span>
                        </a>
                    </div>
                </div>
            </section>
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
}
new OE_front_page();

get_footer('footer.php');