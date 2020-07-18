<?php

/**
 * It's not about getting over it. It's about learning to live with it
 */

/*
Theme Name: Online Exam
Theme URI: http://wordpress.org/themes/online-exam
Author: Arifur Rahman Arif
Author URI: http://wordpress.org/
Description: The 2013 theme for WordPress takes us back to the blog, featuring a full range of post formats, each displayed beautifully in their own unique way. Design details abound, starting with a vibrant color scheme and matching header images, beautiful typography and icons, and a flexible layout that looks great on any device, big or small.
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: black, brown, orange, tan, white, yellow, light, one-column, two-columns, right-sidebar, flexible-width, custom-header, custom-menu, editor-style, featured-images, microformats, post-formats, rtl-language-support, sticky-post, translation-ready
Text Domain: online-exam

This theme, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
 */
?>

<?php get_header('header.php');?>
<section class="oe-post-sec">
    <div class="post_container">
        <?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('./public/includes/template/content', get_post_type());
    }
}
?>
    </div>
    <div class="oe-pagination">
    <span class="pagination_wrap">
 <?php
echo paginate_links(array(
    'prev_text' => 'Prev',
    'next_text' => 'Next',
));
?>
    </span>
</div>
</section>
<?php get_footer('footer.php');?>