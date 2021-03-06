<?php
get_header('header.php');
include_once ABSPATH . 'wp-admin/includes/plugin.php';
if (!function_exists('is_plugin_active') || !is_plugin_active('online-exam/online-exam.php')) {

?>
    <section class="oe-verifcation">
        <div class="veri_container">
            <div class="ver_msg">
                <p>This theme require Online Exam Plugin to work properly</p>
            </div>
            <a href="<?php echo admin_url('plugins.php') ?>">Activate Plugin</a>
        </div>
    </section>
<?php

    get_footer('footer.php');
    return;
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/public/assets/css/login.min.css' ?>">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/login.png' ?>" alt="IMG">
            </div>

            <form id="oe-recover" class="login100-form validate-form">
                <input type="hidden" name="action" value="lost_pass">
                <span class="login100-form-title">
                    Lost Password ?
                </span>
                <span class="oe-warning" style="display: none"></span>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="user" required placeholder="Email or Username">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">
                    <button type='submit' class="login100-form-btn reg-btn">
                        Recover Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo get_template_directory_uri() . '/public/assets/scripts/tilt.jquery.min.js' ?>"></script>
<script>
    jQuery(document).ready(function($) {

        $('.js-tilt').tilt({
            scale: 1.1
        })
    })
</script>
<?php get_footer('footer.php') ?>