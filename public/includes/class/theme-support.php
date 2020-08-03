<?php
class Theme_support
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_filter('excerpt_length', [$this, 'excerpt_len'], 999);
        add_action('init', [$this, 'session_val']);
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

}
new Theme_support();
