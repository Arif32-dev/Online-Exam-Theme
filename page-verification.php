<?php

get_header('header.php');
require_once get_template_directory() . '/public/includes/class/mail.php';

class OE_verification extends Base_mail
{
    public $class;
    public $msg;
    public function __construct()
    {
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        if (!function_exists('is_plugin_active') || !is_plugin_active('online-exam/online-exam.php')) {
            $text = "This theme require Online Exam Plugin to work properly";
            $btn = "Activate Plugin";
            $url = admin_url('plugins.php');
            $this->notify_msg($text, $btn, $url);
            return;
        }
        $this->verify_user();
    }
    public function notify_msg($text, $btn, $url)
    {

?>
        <section class="oe-verifcation">
            <div class="veri_container">
                <div class="ver_msg">
                    <p><?php echo $text ?></p>
                </div>
                <a href="<?php echo $url ?>"><?php echo $btn ?></a>
            </div>
        </section>
<?php

    }
    public function verify_user()
    {
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
                        'role' => 'student',
                    ]
                );
                if (is_int($user_id)) {
                    $respond = $wpdb->update(
                        $table,
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
                        $this->class = "ver_msg";
                        $this->msg = "Your account is verfied. Log in to view you account";
                        $site_url = site_url('/login?email=' . $res[0]->std_email . '&pass=' . $res[0]->std_password . '');
                        $mail_text = "Your account is being verified successfully. Log in to your account by clicking this link";
                        $subject = "Account Verification";
                        $mail_respond = $this->set_mail_info(
                            $res[0]->std_email,
                            get_option('blogname'),
                            $site_url,
                            $subject,
                            $mail_text,
                            'Login to your account',
                            'verification',
                            $res[0]->std_name
                        );
                        if ($mail_respond['res'] != 'success') {
                            echo "Mail couldn't sent";
                        }
                    } else {
                        $this->class = "ver_error";
                        $this->msg = "Either your account is verified or invalid";
                    }
                } else {
                    $this->class = "ver_error";
                    $this->msg = "Something went wrong";
                }
            } else {
                $this->class = "ver_error";
                $this->msg = "Either your account is verified or invalid";
            }
        }
    }
}
$user_verify = new OE_verification();
?>
<section class="oe-verifcation">
    <div class="veri_container">
        <div class="<?php echo isset($user_verify->class) ? $user_verify->class : "" ?>">
            <p><?php echo isset($user_verify->msg) ? $user_verify->msg : "" ?></p>
        </div>
        <a href="<?php echo site_url('/login') ?>">Login</a>
    </div>
</section>
<?php get_footer('footer.php') ?>