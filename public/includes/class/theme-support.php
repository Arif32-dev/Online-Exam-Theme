<?php
class Theme_support
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_filter('excerpt_length', [$this, 'excerpt_len'], 999);
        add_action('init', [$this, 'session_val']);
        add_action('wp_set_comment_status', [$this, 'approve_comment'], 10, 2);
    }
    public function theme_supports()
    {
        add_theme_support('post-thumbnails');
    }
    public function excerpt_len()
    {
        return 50;
    }
    public function session_val()
    {
        if (!session_id()) {
            session_start();
        }
    }
    public function approve_comment($comment_id, $comment_status)
    {
        wp_set_comment_status($comment_id, 'approve');
    }
}
new Theme_support();
