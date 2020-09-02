<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';

class OE_commnet
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
        $this->load_more();
    }
    public function load_more()
    {

        if ($this->data['offset']) {
            $comments_query = new WP_Comment_Query();
            $comments_per_page = $this->data['offset'];
            $_SESSION['offset_data'] = [
                'comments_per_page' => ($comments_per_page + $comments_per_page),
                'post_id' => $this->data['post_id'],
            ];

            $comments = $comments_query->query([
                'status' => 'approve',
                'post_id' => $this->data['post_id'],
                'number' => ($comments_per_page + $comments_per_page),
            ]);

            $zoneList = timezone_identifiers_list();
            if (in_array(wp_timezone_string(), $zoneList)) {
                date_default_timezone_set(wp_timezone_string());
            } else {
                date_default_timezone_set('America/Los_Angeles');
            }

            if ($comments) {

                ?>
                    <div class="all_comments">
                <?php

                foreach ($comments as $comment) {
                    if (get_userdata($comment->user_id)) {

                        if (get_userdata($comment->user_id)->roles[0] == 'administrator') {
                            ?>
                            <li class="comment author-comment">
                                    <div class="info">
                                        <a href=""><?php echo get_userdata($comment->user_id)->data->display_name; ?></a>
                                        <span><?php $this->time_diff($comment->comment_date)?></span>
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
                                            <span><?php $this->time_diff($comment->comment_date)?></span>
                                        </div>
                                        <div class="avatar">
                                            <img src="<?php echo get_avatar_url($comment->user_id); ?>" width="45" alt="Profile Avatar" title="<?php echo get_userdata($comment->user_id)->data->display_name; ?>" />
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
                                        <span><?php $this->time_diff($comment->comment_date)?></span>
                                    </div>
                                    <div class="avatar">
                                        <img src="<?php echo get_avatar_url($comment->user_id) ?>" width="45" alt="Profile Avatar" title="<?php echo $comment->comment_author; ?>" />
                                    </div>
                                    <p><?php echo $comment->comment_content; ?></p>
                            </li>
                        <?php

                    }
                }

                ?>
                    </div>
                <?php

                $this->load_more_btn(($comments_per_page + $comments_per_page));
            }
        }
    }
    public function load_more_btn($comments_per_page)
    {
        $comments_query = new WP_Comment_Query();

        $next_comment = $comments_query->query([
            'status' => 'approve',
            'offset' => $comments_per_page,
            'post_id' => $this->data['post_id'],
            'number' => $comments_per_page,
        ]);
        if ($next_comment) {

            ?>
                <div class="load_more">
                    <button id="oe_load_more" data-post_id="<?php echo $this->data['post_id'] ?>" data-offset="<?php echo $comments_per_page ?>">Load More</button>
                </div>
            <?php

        } else {
            echo '';
        }
    }
    public function time_diff($time)
    {
        $zoneList = timezone_identifiers_list();
        if (in_array(wp_timezone_string(), $zoneList)) {
            date_default_timezone_set(wp_timezone_string());
        } else {
            date_default_timezone_set('America/Los_Angeles');
        }

        $time_diff = abs((time() - strtotime($time)));
        if ($time_diff < 60) {
            echo "" . $time_diff . " second ago";
        }
        if ($time_diff >= 60 && $time_diff <= 120) {
            echo "A min ago";
        }
        if ($time_diff > 120 && $time_diff < 3600) {
            echo "" . intval(($time_diff / 60)) . " min ago";
        }
        if ($time_diff >= 3600 && $time_diff <= 7200) {
            echo "An hour ago";
        }
        if ($time_diff > 7200 && $time_diff < 86400) {
            echo "" . intval(($time_diff / 3600)) . " hour ago";
        }
        if ($time_diff >= 86400 && $time_diff <= 172800) {
            echo "A day ago";
        }
        if ($time_diff > 172800 && $time_diff < 604800) {
            echo "" . intval(($time_diff / 86400)) . " day ago";
        }
        if ($time_diff >= 604800 && $time_diff <= 691200) {
            echo "A week ago";
        }
        if ($time_diff > 691200 && $time_diff < 2592000) {
            echo "" . intval(($time_diff / 86400)) . " day ago";
        }
        if ($time_diff >= 2592000 && $time_diff <= 2678400) {
            echo "A month ago";
        }
        if ($time_diff > 2678400 && $time_diff < 31104000) {
            if (intval(substr(explode('.', ($time_diff / 2592000))[1], 0, 1)) == 0) {
                echo "" . intval(($time_diff / 2592000)) . "month ago";
            } else {
                echo "" . intval(($time_diff / 2592000)) . "M " . intval(substr(explode('.', ($time_diff / 2592000))[1], 0, 1)) . "D ago";
            }
        }
        if ($time_diff >= 31104000 && $time_diff <= 31190400) {
            echo "A year ago";
        }
        if ($time_diff > 31190400) {
            echo "" . intval(($time_diff / 31104000)) . " year ago";
        }
    }
}
new OE_commnet();
