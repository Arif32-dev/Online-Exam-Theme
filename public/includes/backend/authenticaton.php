<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-includes/class-phpmailer.php';
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-includes/class-smtp.php';
require_once './Exception.php';
class Authentication
{
    private $post_data;
    public function __construct()
    {
        $this->post_data = $_POST;
        if ($this->post_data['action'] == 'user_login') {
            if (!$this->post_data['user'] || !$this->post_data['pass']) {
                echo 'One or more field is empty';
                return;
            }
            $this->user_login();
        }
        if ($this->post_data['action'] == 'user_sign_up') {
            $this->user_checking();
        }
    }
    public function user_login()
    {
        $cred = [
            'user_login' => $this->post_data['user'],
            'user_password' => $this->post_data['pass'],
            'remember' => true,
        ];
        $res = wp_signon($cred, true);
        if (!is_wp_error($res)) {
            $user_id = $res->data->ID;
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id, true);
            echo 'success';
        } else {
            if ($res->errors['incorrect_password'][0]) {
                echo 'Incorrect Password';
            }
            if ($res->errors['invalid_username'][0]) {
                echo 'Invalid username';
            }
            if ($res->errors['invalid_email'][0]) {
                echo 'Invalid email';
            }
        }
    }
    public function user_checking()
    {
        if (!$this->post_data['name'] || !$this->post_data['user_name'] || !$this->post_data['email'] || !$this->post_data['pass'] || !$this->post_data['conf_pass'] || !$this->post_data['phn_number'] || !isset($this->post_data['department'])) {
            echo 'One or more field is empty';
            return;
        }
        if ($this->post_data['pass'] !== $this->post_data['conf_pass']) {
            echo "Password didn't matched";
            return;
        }
        if (is_numeric(' ' . $this->post_data['phn_number'] . ' ')) {
            echo "Invalid number";
            return;
        }
        if (username_exists($this->post_data['user_name'])) {
            echo 'Username exists.';
            return;
        }
        if (email_exists($this->post_data['email'])) {
            echo 'Email already exists.';
            return;
        }
        $this->db_checking();
    }
    public function db_checking()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'students';
        $res = $wpdb->get_results("SELECT * FROM " . $table . " WHERE std_email='" . $this->post_data['email'] . "'");
        if ($res) {
            echo 'Email already exists.';
        } else {
            $this->send_verification_mail();
        }
    }

    public function send_verification_mail()
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'dxridder0024@gmail.com'; // SMTP username
        $mail->Password = 'kishoregonj999@BD'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('dxridder0024@gmail.com', '' . get_bloginfo('name') . '');
        $mail->addAddress('' . $this->post_data['email'] . '', 'User'); // Add a recipient
        $mail->addAddress('dxridder0024@gmail.com'); // Name is optional
        $mail->addReplyTo('dxridder0024@gmail.com', 'No reply');

        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Email Confirmation';
        $mail->Body = '
                <h3 style="color: green">Your account is being registered. Please click the link below to verify your account</h3>
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
                href="' . site_url('/verification?std_id=' . md5(sanitize_text_field($this->post_data['email'])) . '') . '" target="_blank"
                >Verify Account</a>
                </h3>
            ';
        $mail->AltBody = '
                Please confirm your email by clicking this link
                ' . site_url('/verification?std_id=' . md5(sanitize_text_field($this->post_data['email'])) . '') . '
            ';
        if ($mail->send()) {
            $this->user_create();
        } else {
            echo 'Something went wrong';
        }
    }
    public function user_create()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'students';
        $res = $wpdb->insert(
            $table,
            [
                'std_id' => md5(sanitize_text_field($this->post_data['email'])),
                'std_name' => sanitize_text_field($this->post_data['name']),
                'std_user_name' => sanitize_text_field($this->post_data['user_name']),
                'dept_id' => sanitize_text_field($this->post_data['department']),
                'std_phone' => sanitize_text_field($this->post_data['phn_number']),
                'std_email' => sanitize_text_field($this->post_data['email']),
                'std_password' => sanitize_text_field($this->post_data['pass']),
                'std_reg_date' => 0,
                'status' => false,
                'restriction' => false,
                'restrict_date' => 0,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
            ]
        );
        if ($res) {
            echo "user_registered";
        } else {
            echo 'failed';
        }
    }
}
new Authentication();
