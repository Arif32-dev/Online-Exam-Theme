<?php
if (is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
}
get_header('header.php');
function oe_department()
{
    global $wpdb;
    $table = $wpdb->prefix . 'department';
    $dept_data = $wpdb->get_results("SELECT * FROM " . $table . "");
    foreach ($dept_data as $dept) {
        echo '
            <option value="' . $dept->dept_id . '">' . $dept->dept_name . '</option>
        ';
    }
}
?>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/public/assets/css/login.min.css' ?>">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/login.png' ?>" alt="IMG">
            </div>

            <form id="oe-reg" class="login100-form validate-form" autocomplete="off">
                <input type="hidden" name="action" value="user_sign_up">
                <span class="login100-form-title">
                    Sign Up
                </span>
                    <span class="oe-warning" style="display:none; white-space: nowrap">Sorry! Incorrect Password</span>
                <div class="wrap-input100 validate-input" >
                    <input class="input100" type="text" name="name" required placeholder="Enter your name">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="user_name"  required placeholder="Enter user name">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" >
                    <input class="input100" type="email" name="email" required placeholder="Enter your email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" >
                    <input class="input100" type="password" name="pass" required placeholder="Enter your password" autocomplete="off">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" >
                    <input class="input100" type="password" name="conf_pass" required placeholder="Confirm password" autocomplete="off">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" >
                    <input class="input100" type="number" name="phn_number" required placeholder="Phone number">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-phone-alt"></i>
                    </span>
                </div>
                <!-- Department -->
                <div class="wrap-input100 dept_sec">
                    <select required name="department" form="oe-reg" >
                        <option value="" hidden selected disabled>Select Department</option>
                            <?php oe_department();?>
                    </select>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-arrow-circle-down"></i>
                    </span>
                </div>
                <!-- End of Department -->

                <div class="container-login100-form-btn">
                    <button  type="submit" class="login100-form-btn reg-btn">
                        Sign Up
                    </button>
                </div>
                <div class="text-center p-t-136 oe-login">
                    <a href="<?php echo site_url('/login') ?>" class="txt2" href="#">
                        Log In to your account
                       <i class="fas fa-arrow-right"></i>
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
