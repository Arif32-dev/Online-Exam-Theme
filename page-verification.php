<?php
require_once dirname(dirname(dirname(get_template_directory()))) . '/wp-includes/class-phpmailer.php';
require_once dirname(dirname(dirname(get_template_directory()))) . '/wp-includes/class-smtp.php';
?>
<?php get_header('header.php')?>
<?php
if (isset($_GET['std_id'])) {
    $std_id = $_GET['std_id'];
    global $wpdb;
    $table = $wpdb->prefix . 'students';
    $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE std_id='" . $std_id . "' AND status=0");
    if ($res) {
        $user_id = wp_insert_user(
            [
                'user_pass' => $res[0]->std_password,
                'user_login' => $res[0]->std_user_name,
                'user_email' => $res[0]->std_email,
                'display_name' => $res[0]->std_name,
                'show_admin_bar_front' => 'false',
                'role' => 'subscriber',
            ]
        );
        if (is_int($user_id)) {
            $respond = $wpdb->update($table,
                [
                    'std_id' => $user_id,
                    'std_password' => 'empty',
                    'status' => true,
                    'std_reg_date' => time(),
                ],
                [
                    'std_id' => $std_id,
                ],
                [
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                ],
                [
                    '%d',
                ]
            );
            if ($respond) {
                $class = "ver_msg";
                $msg = "Your account is verfied. Log in to view you account";
                send_login_email($res[0]->std_email);
            } else {
                $class = "ver_error";
                $msg = "Either your account is verified or invalid";
            }
        } else {
            $class = "ver_error";
            $msg = "Something went wrong";
        }
    } else {
        $class = "ver_error";
        $msg = "Either your account is verified or invalid";
    }
}
function send_login_email($email)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = '' . get_option('mailer_gmail') . ''; // SMTP username
    $mail->Password = '' . get_option('mailer_pass') . ''; // SMTP password
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//Recipients
    $mail->setFrom('' . get_option('mailer_gmail') . '', '' . get_bloginfo('name') . '');
    $mail->addAddress('' . $email . '', 'User'); // Add a recipient

    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Registration Successfull';
    $mail->Body = '
                <h3 style="color: green">Your account is being registered successfully. Log in to your account by clicking this link</h3>
                <h3>
                <a
                style="
                text-decoration: none;
                outline: none;
                padding: 7px 12px;
                font-size: 12px;
                letter-spacing: 1px;
                border: 1px solid #3cc78f;
                background-color: #3cc78f;
                white-space: nowrap;
                color: white;
                font-weight: bolder;
                cursor: pointer;
                border-radius: 20px;
                -webkit-border-radius: 20px;
                -moz-border-radius: 20px;
                -ms-border-radius: 20px;
                -o-border-radius: 20px;
                 transition: all 0.5s ease-in-out;
                -webkit-transition: all 0.5s ease-in-out;
                -moz-transition: all 0.5s ease-in-out;
                -ms-transition: all 0.5s ease-in-out;
                -o-transition: all 0.5s ease-in-out;
                "
                href="' . site_url('/login') . ' " target="_blank"
                >Login to your account</a>
                </h3>
            ';
    $mail->AltBody = '
                Please confirm your email by clicking this link
                ' . site_url('/login') . '
            ';
    if (!$mail->send()) {
        echo "Mail couldn't sent";
    }
}
?>
<section class="oe-verifcation">
    <div class="veri_container">
        <div class="<?php echo isset($class) ? $class : "" ?>">
            <p><?php echo isset($msg) ? $msg : "" ?></p>
        </div>
        <a href="<?php echo site_url('/login') ?>">Login</a>
    </div>
</section>
<?php get_footer('footer.php')?>