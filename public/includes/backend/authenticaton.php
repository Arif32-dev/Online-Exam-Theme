<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once get_theme_file_path() . '/public/includes/class/mail.php';
class Authentication extends Base_mail
{
    private $post_data;
    private $new_pass;
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
        if ($this->post_data['action'] == 'lost_pass') {
            if (username_exists($this->post_data['user']) || email_exists($this->post_data['user'])) {
                $this->lost_password();
            } else {
                echo "User don't exists. Please try again";
            }
        }
        if ($this->post_data['action'] == 'contact_us') {
            $this->contact_form();
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
            if (array_key_exists("incorrect_password", $res->errors)) {
                if ($res->errors['incorrect_password'][0]) {
                    echo 'Incorrect Password';
                }
            }
            if (array_key_exists("invalid_username", $res->errors)) {
                if ($res->errors['invalid_username'][0]) {
                    echo 'Invalid username';
                }
            }
            if (array_key_exists("invalid_email", $res->errors)) {
                if ($res->errors['invalid_email'][0]) {
                    echo 'Invalid email';
                }
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
            echo 'Username exists';
            return;
        }
        if (email_exists($this->post_data['email'])) {
            echo 'Email already exists';
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
            $site_url = site_url('/verification?std_id=' . md5(sanitize_text_field($this->post_data['email'])));
            $subject = "Account Registration";
            $mail_text = "Your account is being registered. Please click the link below to verify your account";
            $alt_text = "Please confirm your email by clicking this link";
            if ($this->send_mail($this->post_data['email'], get_option('mailer_gmail'), $site_url, $subject, $mail_text, 'Verify Account', $alt_text, true)) {
                $this->user_create();
            } else {
                echo 'Something went wrong';
            }
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
    public function lost_password()
    {
        if (get_user_by('email', sanitize_text_field($this->post_data['user']))) {
            $user_data = get_user_by('email', sanitize_text_field($this->post_data['user']));
            $this->new_pass = wp_generate_password();
        } else {
            $user_data = get_user_by('login', sanitize_text_field($this->post_data['user']));
            $this->new_pass = wp_generate_password();
        }
        $user_id = wp_update_user([
            'ID' => $user_data->data->ID,
            'user_pass' => $this->new_pass,
        ]);
        if (is_int($user_id)) {
            $site_url = site_url('/login?email=' . $user_data->data->user_email . '&pass=' . $this->new_pass . '');
            $subject = "Account Registration";
            $mail_text = "Your Login Email : " . $user_data->data->user_email . "  & Your Password : <strong style='color: black;'>" . $this->new_pass . "</strong>";
            if ($this->send_mail($user_data->data->user_email, get_option('mailer_gmail'), $site_url, $subject, $mail_text, 'Log In', $mail_text, true)) {
                echo 'recovered';
            } else {
                echo 'Something went wrong';
            }
        } else {
            echo 'Something went wrong';
        }
    }
    public function contact_form()
    {
        $subject = "Contact Messege";
        $mail_text = "" . $this->post_data['msg'] . "";
        if (is_user_logged_in()) {
            $user_data = get_userdata(get_current_user_id());
            if ($this->send_mail(get_option('mailer_gmail'), $user_data->data->user_email, '', $subject, $mail_text, '', $mail_text, false)) {
                echo 'contact_us_success';
            } else {
                echo 'Something went wrong';
            }
        } else {

            if ($this->send_mail(get_option('mailer_gmail'), $this->post_data['email'], '', $subject, $mail_text, '', $mail_text, false)) {
                echo 'contact_us_success';
            } else {
                echo 'Something went wrong';
            }
        }
    }
}
new Authentication();
