<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-includes/class-phpmailer.php';
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-includes/class-smtp.php';

class Base_mail
{

    public function send_mail($email, $site_url, $mail_text, $btn_text, $alt_text)
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
        $mail->Subject = 'Email Confirmation';
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
        return $mail->send();
    }
}
