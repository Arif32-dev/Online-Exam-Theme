<?php
class OE_function
{
    public function __construct()
    {
        add_action("wp_enqueue_scripts", [$this, 'oe_files']);
        $this->include_other_class();
    }
    public function oe_files()
    {
        // styles
        wp_enqueue_style("online-exam_style", get_stylesheet_uri());
        wp_enqueue_style("online-exam_style_poppins", "//fonts.googleapis.com/css2?family=Poppins&display=swap");
        // scripts
        wp_enqueue_script('jquery');
        wp_enqueue_script('online-exam_fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js', '', '1.0.0', true);
        wp_enqueue_script('online-exam_main', get_template_directory_uri() . '/public/assets/scripts/online_exam.min.js', 'jquery', '1.0.0', true);
        wp_localize_script('online-exam_main', 'files', [
            'site_url' => site_url(),
            'authentication_page' => get_template_directory_uri() . '/public/includes/backend/authenticaton.php',
            'comment_file' => get_template_directory_uri() . '/public/includes/backend/comment.php',
            'profile' => get_template_directory_uri() . '/public/includes/backend/profile.php',
            'answer' => get_template_directory_uri() . '/public/includes/backend/answer.php',
            'exam_result' => site_url('/exam-result'),
            'bulk_answer' => get_template_directory_uri() . '/public/includes/backend/bulk_answer.php',
        ]);
    }
    public function include_other_class()
    {
        require_once get_theme_file_path() . '/public/includes/class/add-page.php';
        require_once get_theme_file_path() . '/public/includes/class/theme-support.php';
        require_once get_theme_file_path() . '/public/includes/class/user_login_sign_up.php';
    }
}
new OE_function();
