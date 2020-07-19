<?php
get_header('header.php');
class Single_post
{
    public function __construct()
    {
        $this->single_post();
    }
    public function single_post()
    {
        if (have_posts()) {
            while (have_posts()) {
                the_post();

                ?>
               <section class="single_post">
                        <?php $this->img_sec();?>
                        <?php $this->content_sec();?>
                        <?php $this->comment_sec();?>
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

        }
    }
    public function content_sec()
    {

        ?>
                <div class="desc">
                    <h1><?php echo get_the_title(); ?></h1>
                    <div class="post_details">
                        <span><strong>Posted By :</strong> <?php echo get_the_author() ?></span>
                        <span><strong>Published Date :</strong> <?php echo get_the_date("Y-m-d / h:i:sa") ?></span>
                     </div>
                    <p>
                        <?php echo get_the_content() ?>
                    </p>
                </div>
        <?php

    }
    public function comment_sec()
    {

        ?>
        <h1>comment_sec</h1>
        <?php

    }
}
new Single_post();
get_footer('footer.php');
