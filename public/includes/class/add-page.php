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
    public static function insert_post_arr(string $title)
    {
        return [
            'post_title' => $title,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => "",
        ];
    }
    public static function create_page()
    {
        if (!get_page_by_title('Home')) {
            wp_insert_post(self::insert_post_arr('Home'), true);
        }
        if (!get_page_by_title('Blog')) {
            wp_insert_post(self::insert_post_arr('Blog'), true);
        }
        if (!get_page_by_title('Department')) {
            wp_insert_post(self::insert_post_arr('Department'), true);
        }
        if (!get_page_by_title('Exam Result')) {
            wp_insert_post(self::insert_post_arr('Exam Result'), true);
        }
        if (!get_page_by_title('Previous Result')) {
            wp_insert_post(self::insert_post_arr('Previous Result'), true);
        }
        if (!get_page_by_title('Result Folder')) {
            wp_insert_post(self::insert_post_arr('Result Folder'), true);
        }
        if (!get_page_by_title('Login')) {
            wp_insert_post(self::insert_post_arr('Login'), true);
        }
        if (!get_page_by_title('Sign Up')) {
            wp_insert_post(self::insert_post_arr('Sign Up'), true);
        }
        if (!get_page_by_title('Verification')) {
            wp_insert_post(self::insert_post_arr('Verification'), true);
        }
        if (!get_page_by_title('Lost Password')) {
            wp_insert_post(self::insert_post_arr('Lost Password'), true);
        }
        if (!get_page_by_title('Previous Routine')) {
            wp_insert_post(self::insert_post_arr('Previous Routine'), true);
        }

    }
}
new Add_page();
