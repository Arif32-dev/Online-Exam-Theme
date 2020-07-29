<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
class OE_commnet
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
        $this->add_comment();
    }
    public function add_comment()
    {
        $respond = wp_insert_comment([
            'comment_author' => get_userdata(get_current_user_id())->data->display_name,
            'comment_author_email' => get_userdata(get_current_user_id())->user_email,
            'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
            'comment_author_url' => get_userdata(get_current_user_id())->data->user_url,
            'comment_content' => sanitize_text_field($this->data['oe_comment']),
            'comment_post_ID' => sanitize_text_field($this->data['post_id']),
            'user_id' => get_current_user_id(),
        ]);
        if ($respond) {
            echo 'success';
        } else {
            echo 'failed';
        }
    }
}
new OE_commnet();
