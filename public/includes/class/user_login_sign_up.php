<?php
class User_auth
{
    public function __construct()
    {
        add_action('wp_logout', [$this, 'redirect_to_login']);
        add_action('init', [$this, 'url_redirect']);
        add_action('admin_init', [$this, 'redirectSub']);
    }
    public function redirect_to_login()
    {
        wp_redirect(site_url('/login'));
        exit;
    }
    public function url_redirect()
    {
        global $pagenow;

        if ($pagenow === "wp-login.php") {
            wp_redirect(site_url('/log-in'));
            wp_logout();
            exit;
        }
    }
    public function redirectSub()
    {
        if (get_userdata(get_current_user_id())->roles[0] == 'subscriber') {
            wp_redirect(site_url('/'));
            exit;
        }
    }
}
new User_auth();
