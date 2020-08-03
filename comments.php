<?php

$comments_query = new WP_Comment_Query();
$comments_per_page = 1;
$number = isset($_SESSION['offset_data']) ? $_SESSION['offset_data']['post_id'] == get_the_ID() ? $_SESSION['offset_data']['comments_per_page'] : $comments_per_page : $comments_per_page;
$comments = $comments_query->query([
    'status' => 'approve',
    'post_id' => get_the_ID(),
    'number' => $number,
]);
date_default_timezone_set(wp_timezone_string());
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
                                        <span><?php time_diff(get_comment_date("Y-m-d   h:i:sa"))?></span>
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
                            <span><?php time_diff(get_comment_date("Y-m-d   h:i:sa"))?></span>
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
                            <span><?php time_diff(get_comment_date("Y-m-d   h:i:sa"))?></span>
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

    load_more($comments_per_page);
}
function load_more($comments_per_page)
{
    $comments_query = new WP_Comment_Query();
    $number = isset($_SESSION['offset_data']) ? $_SESSION['offset_data']['post_id'] == get_the_ID() ? $_SESSION['offset_data']['comments_per_page'] : $comments_per_page : $comments_per_page;

    $next_comment = $comments_query->query([
        'status' => 'approve',
        'offset' => $number,
        'number' => $number,
        'post_id' => get_the_ID(),
    ]);
    if ($next_comment) {
        ?>
            <div class="load_more">
                <button id="oe_load_more" data-post_id="<?php echo get_the_ID() ?>" data-offset="<?php echo $comments_per_page ?>">Load More</button>
            </div>
        <?php

    } else {
        echo '';
    }

}
function time_diff($time)
{
    date_default_timezone_set(wp_timezone_string());

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
