<?php
class Theme_support
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'theme_supports']);

        add_filter('excerpt_length', [$this, 'excerpt_len'], 999);

    }
    public function theme_supports()
    {
        add_theme_support('post-thumbnails');
    }
    public function excerpt_len()
    {
        return 50;
    }

}
new Theme_support();
