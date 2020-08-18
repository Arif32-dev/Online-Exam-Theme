<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once get_theme_file_path() . '/public/includes/backend/php-mailer.php';
require_once get_theme_file_path() . '/public/includes/backend/smtp.php';

class Base_mail
{

    public function send_mail($email, $reply_email, $site_url, $subject, $mail_text, $btn_text, $alt_text, $should_use_btn)
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
        $mail->addReplyTo('' . $reply_email . '', 'Reply');
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = '' . $subject . '';
        if ($should_use_btn) {
            $mail->Body = '
                <h3 style="color: green">' . $mail_text . '</h3>
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
                href="' . $site_url . '" target="_blank"
                >' . $btn_text . '</a>
                </h3>
            ';
            $mail->AltBody = '
                ' . $alt_text . '
                ' . $site_url . '
            ';
        } else {
            $mail->Body = '
                <h3>' . $mail_text . '</h3>';
            $mail->AltBody = '
                ' . $alt_text . '
            ';
        }
        return $mail->send();
    }
}
