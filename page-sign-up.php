<?php get_header('header.php')?>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/public/assets/css/login.min.css' ?>">
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="<?php echo get_template_directory_uri() . '/public/assets/img/login.png' ?>" alt="IMG">
            </div>

            <form id="oe-reg" class="login100-form validate-form" autocomplete="off">
                <span class="login100-form-title">
                    Sign Up
                </span>
                    <span class="oe-warning" style="display: none">Sorry! Incorrect Password</span>
                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="name" placeholder="Enter your name">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-user"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="email" name="email" placeholder="Email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="number" name="phn_number" placeholder="Phone number">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-phone-alt"></i>
                    </span>
                </div>
                <!-- Department -->
                <div class="wrap-input100 dept_sec">
                    <select name="department" form="oe-reg" >
                        <option value="" hidden selected disabled>Select Department</option>
                        <option value="">Math</option>
                        <option value="">Physics</option>
                        <option value="">English</option>
                        <option value="">Biology</option>
                    </select>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fas fa-arrow-circle-down"></i>
                    </span>
                </div>
                <!-- End of Department -->

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
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
