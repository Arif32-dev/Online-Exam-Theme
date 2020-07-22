<?php
class Theme_support
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'theme_supports']);

        add_filter('excerpt_length', [$this, 'excerpt_len'], 999);
        add_filter('wp_mail_content_type', [$this, 'mail_content']);
    }
    public function theme_supports()
    {
        add_theme_support('post-thumbnails');
    }
    public function excerpt_len()
    {
        return 50;
    }

    public function mail_content()
    {
        return 'text/html';
    }
}
new Theme_support();
