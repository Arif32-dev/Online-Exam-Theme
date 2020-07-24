<?php
if (!class_exists('Theme_setting')) {
    return;
}
class Theme_setting
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menus']);
        add_action('admin_init', [$this, 'register_settings']);

    }
    public function add_admin_menus()
    {
        add_menu_page(
            'OE Theme Setting',
            'Theme Setting',
            'manage_options',
            'oe_theme_setting',
            [$this, 'theme_setting'],
            'dashicons-admin-generic',
            98
        );
    }
    public function theme_setting()
    {

        ?>
        <style>
            table th {
              display: none
            }
        </style>
        <h3>Please use a dummy gmail to send email to your users. Create a new gmail in order to send email to your user. Your account and password will only be used in this theme. If you delete this theme your given info will be deleted also. Don't use a personal email or business email. </h3>
            <div class="wrap">
                <p>Please deactive 2-step verification and active your gmail less secure app turn on to send gmail <a target="blank" href="https://myaccount.google.com/lesssecureapps">Click here</a></p>
            <form  action="options.php" method='POST'>
                    <?php settings_fields('oe-theme-set')?>
                    <?php do_settings_sections('oe_theme_setting')?>
                    <?php submit_button('Save Settings');?>
            </form>
            </div>
        <?php

    }
    public function register_settings()
    {
        register_setting('oe-theme-set', 'mailer_gmail');
        register_setting('oe-theme-set', 'mailer_pass');
        add_settings_section(
            'oe-theme-sec',
            '',
            "",
            'oe_theme_setting'
        );

        add_settings_field(
            'mailer_setting',
            '',
            [$this, 'mailer_setting'],
            'oe_theme_setting',
            'oe-theme-sec',
        );

    }

    public function mailer_setting()
    {

        ?>
            <label for="gmail">Your Gmail :</label>
            <input type="text" placeholder="Your gmail account" name="mailer_gmail" value="<?php echo get_option('mailer_gmail') ? get_option('mailer_gmail') : "" ?>">
            <br>
            <br>
            <label for="gmail">Gmail Password :</label>
            <input type="password" placeholder="Your gmail password" name="mailer_pass" value="<?php echo get_option('mailer_pass') ? get_option('mailer_pass') : "" ?>">
            <br>
        <?php

    }
}
new Theme_setting();
