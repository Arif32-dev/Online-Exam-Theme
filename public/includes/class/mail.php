<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once get_theme_file_path() . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class Base_mail
{

    public function set_mail_info($email, $reply_to_name, $site_url, $subject, $mail_text, $btn_text, $action, $recipent_name)
    {

        if ($action == 'registration' || $action == 'verification' || $action == 'lost_pass') {
            $mail_body = '
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
            return $this->send_messege($email, $reply_to_name, $subject, $mail_body, $action, $recipent_name);
        } else {
            $mail_body = '
                <h3>' . $mail_text . '</h3>';
            return $this->send_messege($email, $reply_to_name, $subject, $mail_body, $action, $recipent_name);
        }
    }
    public function createMessage($sender, $to, $reply_to, $reply_to_name, $subject, $messageText, $recipent_name)
    {
        $message = new \Google_Service_Gmail_Message();

        $mail = new PHPMailer();
        $mail->SMTPAuth = true;
        $mail->setFrom($sender, '' . get_option('blogname') . '');
        $mail->addAddress($to, $recipent_name);
        $mail->addAddress($recipent_name);
        $mail->addReplyTo($reply_to, '' . $reply_to_name . '');


        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $messageText;
        $mail->preSend();
        $mime = $mail->getSentMIMEMessage();

        $rawMessage = strtr(base64_encode($mime), array('+' => '-', '/' => '_'));
        $message->setRaw($rawMessage);
        return $message;
    }
    public function service()
    {
        $client = $this->get_client();
        $service = new \Google_Service_Gmail($client);
        return $service;
    }
    public function get_client()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Online Exam Gmail Setup');
        $client->setScopes(\Google_Service_Gmail::MAIL_GOOGLE_COM);
        $client->setAuthConfig(get_option('credentials'));

        if (get_option('access_token')) {
            $client->setAccessToken(get_option('access_token'));
        }
        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            }
        }
        return $client;
    }
    public function send_messege($target_email, $reply_to_name, $subject, $messge_text, $action, $recipent_name)
    {
        $authenticated_email = $this->service()->users->getProfile('me')->getEmailAddress();
        if ($action == 'registration' || $action == 'verification' || $action == 'lost_pass') {
            $sending_msg = $this->createMessage(
                $authenticated_email,
                sanitize_text_field($target_email),
                $authenticated_email,
                $reply_to_name,
                $subject,
                $messge_text,
                $recipent_name
            );
        }
        if ($action == 'contact_us') {
            $sending_msg = $this->createMessage(
                $authenticated_email,
                $authenticated_email,
                sanitize_text_field($target_email),
                $reply_to_name,
                $subject,
                $messge_text,
                $recipent_name
            );
        }

        try {
            $message = $this->service()->users_messages->send($authenticated_email, $sending_msg);
            $output_array = [
                'res' => 'success',
                'returned' => 'Message with ID: ' . $message->getId() . ' sent.'
            ];
            return $output_array;
        } catch (Exception $e) {
            $output_array = [
                'res' => 'failed',
                'returned' => $e->getMessage()
            ];
            return $output_array;
        }
    }
}
