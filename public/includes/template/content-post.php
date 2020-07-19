<div class="post_wrap">
    <h1><?php echo get_the_title() ?></h1>
<?php
if (get_the_post_thumbnail_url()) {

    ?>
    <a href="" class="post_img">
        <img src=" <?php echo get_the_post_thumbnail_url() ?>" alt="">
    </a>
    <?php
}
if (get_the_excerpt()) {

    ?>
    <div class="post_content">
        <p>
            <?php echo get_the_excerpt() ?>
        </p>
    </div>
    <?php
}
?>
    <div class="post_details">
        <span><strong>Posted By :</strong> <?php echo get_the_author() ?></span>
        <span><strong>Published Date :</strong> <?php echo get_the_date("Y-m-d / h:i:sa") ?></span>
    </div>
    <a class="view_post" href="<?php echo get_the_permalink() ?>">View Post</a>
</div>