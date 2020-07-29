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
               <?php $this->display_comments();?>
                <li class="write-new">
                    <?php $this->comment_by_logged_in();?>
                </li>
		</ul>
        <?php

    }
    public function comment_by_logged_in()
    {
        if (is_user_logged_in()) {

            ?>
                <form id="oe-comment-form" method="post">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID() ?>">
                        <textarea placeholder="Write your comment here" name="oe_comment"></textarea>
                        <div>
                            <img src="<?php echo get_avatar_url(1) ?>" width="45" alt="Profile of Bradley Jones" title="Bradley Jones" />
                            <span><?php echo get_userdata(get_current_user_id())->data->display_name; ?></span>
                            <button type="submit">Comment</button>
                        </div>
                 </form>
            <?php

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
        $comments_query = new WP_Comment_Query([
            'post_id' => get_the_ID(),
        ]);
        if (!$comments_query->comments) {
            return;
        }
        foreach ($comments_query->comments as $comment) {
            if (get_userdata($comment->user_id)) {

                if (get_userdata($comment->user_id)->roles[0] == 'administrator') {
                    ?>
                <li class="comment author-comment">
                        <div class="info">
                            <a href=""><?php echo get_userdata($comment->user_id)->data->display_name; ?></a>
                            <span>3 hours ago</span>
                            <span><strong><?php echo get_userdata($comment->user_id)->roles[0]; ?></strong></span>
                        </div>
                        <div class="avatar">
                            <img src="<?php echo get_template_directory_uri() . '/public/assets/img/avatar.png' ?>" width="45" alt="Profile Avatar" title="<?php echo get_userdata(1)->data->display_name; ?>" />
                        </div>
                        <p><?php echo $comment->comment_content; ?></p>
                </li>
                <?php

                } else {

                    ?>
                    <li class="comment user-comment">
                        <div class="info">
                            <a href=""><?php echo get_userdata($comment->user_id)->data->display_name; ?></a>
                            <span>4 hours ago</span>
                            <span><strong><?php echo get_userdata($comment->user_id)->roles[0]; ?></strong></span>
                        </div>
                        <div class="avatar">
                            <img src="<?php echo get_avatar_url($comment->user_id) ?>" width="45" alt="Profile Avatar" title="<?php echo get_userdata($comment->user_id)->data->display_name; ?>" />
                        </div>
                        <p><?php echo $comment->comment_content; ?></p>
                </li>
                <?php

                }
            } else {

                ?>
                    <li class="comment user-comment">
                        <div class="info">
                            <a href=""><?php echo $comment->comment_author; ?></a>
                            <span>4 hours ago</span>
                            <span><strong></strong></span>
                        </div>
                        <div class="avatar">
                            <img src="<?php echo get_avatar_url($comment->user_id) ?>" width="45" alt="Profile Avatar" title="<?php echo $comment->comment_author; ?>" />
                        </div>
                        <p><?php echo $comment->comment_content; ?></p>
                </li>
                <?php

            }
        }
    }
    public function time_diff($time)
    {
        $comment_time = strtotime($time);
        $time_diff = abs((time() - $comment_time));
        if ($time_diff < 60) {
            echo "" . $time_diff . " second ago";
        }
        if ($time_diff == 60) {
            echo "a min ago";
        }
        if (intval(($time_diff / 60))) {
            echo "" . intval(($time_diff / 60)) . " min ago";
        }
    }
}
new Single_post();
get_footer('footer.php');
