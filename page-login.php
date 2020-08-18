<?php
if ($_GET) {
    if ($_GET['email'] && $_GET['pass']) {
        if (get_user_by('email', sanitize_text_field($_GET['email']))) {
            if (email_exists($_GET['email'])) {
                $cred = [
                    'user_login' => $_GET['email'],
                    'user_password' => $_GET['pass'],
                    'remember' => true,
                ];
                $res = wp_signon($cred, true);
                if (!is_wp_error($res)) {
                    $user_id = $res->data->ID;
                    wp_set_current_user($user_id);
                    wp_set_auth_cookie($user_id, true);
                    wp_redirect(site_url('/'));
                    exit;
                } else {
                    $email = $_GET['email'];
                    $pass = $_GET['pass'];
                }
            }
        }
    }
}
get_header('header.php');
?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/public/assets/css/login.min.css' ?>">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/login.png' ?>" alt="IMG">
            </div>

            <form id="oe-login-form" class="login100-form validate-form">
                <input type="hidden" name="action" value="user_login">
                <span class="login100-form-title">
                     Login
                </span>
                    <span class="oe-warning"  style="display: none">Sorry! Incorrect Password</span>
                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="user" value="<?php echo isset($email) ? $email : "" ?>" required  placeholder="Email or Username">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" >
                    <input class="input100" type="password" value="<?php echo isset($pass) ? $pass : "" ?>" name="pass" required placeholder="Password" autocomplete="off">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">
                    <button type='submit' class="login100-form-btn">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-12">
                    <a class="txt2" href="<?php echo site_url('/lost-password') ?>">
                        Lost / Forgot Password?
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a href="<?php echo site_url('/sign-up') ?>" class="txt2" href="#">
                        Create your Account
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="<?php echo get_template_directory_uri() . '/public/assets/scripts/tilt.jquery.min.js' ?>"></script>
    <script>
        jQuery(document).ready(function($){

        $('.js-tilt').tilt({
            scale: 1.1
        })
        })
    </script>

<?php get_footer('footer.php')?>