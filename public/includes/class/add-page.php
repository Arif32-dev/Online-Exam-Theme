<?php
class Add_page
{
    public function __construct()
    {
        add_action('after_switch_theme', [$this, 'add_page']);
    }
    public function add_page()
    {
        self::create_page();
        $home_page_id = get_page_by_title('Home');
        $blog_page_id = get_page_by_title('Blog');
        update_option('page_on_front', $home_page_id->ID);
        update_option('page_for_posts', $blog_page_id->ID);
        update_option('show_on_front', 'page');
    }
    public static function create_page()
    {
        wp_insert_post(
            [
                'post_title' => 'Home',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => "",

            ],
            true
        );
        wp_insert_post(
            [
                'post_title' => 'Blog',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => "",

            ],
            true
        );
        wp_insert_post(
            [
                'post_title' => 'Department',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => "",

            ],
            true
        );
        wp_insert_post(
            [
                'post_title' => 'Login',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => "",

            ],
            true
        );
        wp_insert_post(
            [
                'post_title' => 'Sign Up',
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => "",

            ],
            true
        );

    }
}
new Add_page();
