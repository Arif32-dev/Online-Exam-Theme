
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name')?></title>
    <?php wp_head()?>

</head>

<body>
    <!-- header-start -->
    <header>
            <div class="container">
                <div class="logo">
                    <img src="<?php echo get_template_directory_uri() . '/public/assets/img/logo.png' ?>" alt="">
                </div>
                <div class="link">
                    <nav>
                        <a href="">Home</a>
                        <a href="">Blog</a>
                        <a href="">Department</a>
                    </nav>
                    <div class="user-cred">
                        <a href="">Login</a>
                        <a href="">Sign Up</a>
                    </div>
                </div>
                <div class="hamburger">
                        <span>
                            <i class="fas fa-bars"></i>
                        </span>
                </div>
                <div class="mobile_link">

                        <a href="">Home</a>
                        <a href="">Blog</a>
                        <a href="">Department</a>
                        <a href="">Login</a>
                        <a href="">Sign Up</a>
                </div>
            </div>
    </header>
  <!-- header-end -->

