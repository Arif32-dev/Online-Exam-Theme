<?php
class OE_function
{
    public function __construct()
    {
        add_action("wp_enqueue_scripts", [$this, 'oe_files']);
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
    }
}
new OE_function();
