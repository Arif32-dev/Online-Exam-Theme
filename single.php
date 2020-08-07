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
        <ul class="comment-section">
            <div class="comments_area">
               <?php $this->display_comments();?>
            </div>
                <li class="write-new">
                    <?php $this->comment_by_logged_in();?>
                </li>
		</ul>
        <?php

    }
    public function comment_by_logged_in()
    {
        if (is_user_logged_in()) {
            if (comments_open()) {

                comment_form(
                    [
                        'logged_in_as' => '',
                        'class_submit' => 'oe_comment_submit',
                        'title_reply' => 'Leave a Reply :',
                    ],
                    get_the_ID()
                );
            }
        } else {

            ?>
                 <span class="comment_txt">
                        Please log in to comment
                        <span><i class="fas fa-comment-slash"></i></span>
                </span>
            <?php

        }

    }
    public function display_comments()
    {
        comments_template();
    }
}
new Single_post();
get_footer('footer.php');
