<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name')?></title>
    <?php wp_head()?>

</head>

<body <?php body_class()?>>
<?php
function is_user_is_oe_user()
{
    if (get_userdata(get_current_user_id())->roles[0] != 'subscriber') {

        ?>
            <a style="white-space: nowrap;" class="<?php active_link("Profile")?>" href="<?php echo site_url('/profile') ?>">Profile</a>
        <?php

    } else {
        echo "";
    }
}
function oe_user_login()
{
    if (is_user_logged_in()) {

        is_user_is_oe_user();

        ?>
            <a class="<?php active_link('Login')?>" href="<?php echo esc_url(wp_logout_url(site_url('/login'))) ?>">Log Out</a>
        <?php

    } else {

        ?>
            <a class="<?php active_link('Login')?>" href="<?php echo esc_url(site_url('/login')) ?>">Login</a>
            <a class="<?php active_link('Sign Up')?>" href="<?php echo esc_url(site_url('/sign-up')) ?>">Sign Up</a>
        <?php

    }
}

function active_link($link)
{
    $page = get_page_by_title($link);

    if (get_queried_object_id() == $page->ID) {
        echo 'oe-active';
    } else {
        echo '';
    }
}
function department_visbility()
{
    if (is_user_logged_in()) {

        ?>
            <a class="<?php active_link('Department')?>" href="<?php echo site_url('/department') ?>">Department Exam</a>
        <?php

    }
}
?>
    <!-- header-start -->
    <header>
            <div class="container">
                <a href="<?php echo site_url() ?>" class="logo">
                    <img src="<?php echo get_template_directory_uri() . '/public/assets/img/logo.png' ?>" alt="">
                </a>
                <div class="link">
                    <nav>
                        <a class="<?php active_link('Home')?>" href="<?php echo site_url('/home') ?>">Home</a>
                        <a class="<?php active_link('Blog')?>"  href="<?php echo site_url('/blog') ?>">Blog</a>
                        <?php department_visbility();?>
                    </nav>
                    <div class="user-cred">
                        <?php oe_user_login()?>
                    </div>
                </div>
                <div class="hamburger">
                        <span>
                            <i class="fas fa-bars"></i>
                        </span>
                </div>
                <div class="mobile_link">

                        <a class="<?php active_link('Home')?>" href="<?php echo site_url('/home') ?>">Home</a>
                        <a class="<?php active_link('Blog')?>" href="<?php echo site_url('/blog') ?>">Blog</a>
                        <a class="<?php active_link('Department')?>" href="<?php echo site_url('/department') ?>">Department Exam</a>
                        <?php oe_user_login()?>
                </div>
            </div>
    </header>
  <!-- header-end -->

