<?php

class NotifyItAdmin {

    private static $initiated = false;
    private static $options;

    public static function init()
    {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    /**
     * Initializes wordPress hooks and get options
     */
    private static function init_hooks()
    {
        self::$initiated = true;

        if ( get_option('notify_options') ) {
            self::$options = get_option('notify_options');
        } else {
            self::$options = array();
        }
        
        // delete_option('notify_options');
        add_action('admin_menu', array('NotifyItAdmin', 'add_notify_in_menu'));
        add_action('admin_init', array('NotifyItAdmin', 'register_settings_and_fields'));
        add_action('admin_head', array('NotifyItAdmin', 'add_css_in_admin_panel'));
    }

    public static function add_notify_in_menu()
    {
        add_options_page('Notifyit', 'Notifyit', 'administrator', 'notify', array('NotifyItAdmin', 'display_notify_structure'));
    }

    public static function register_settings_and_fields()
    {
        register_setting('notify_group', 'notify_options', array('NotifyItAdmin', 'validate_settings'));
        add_settings_section('notify_section', 'Notifyit Settings', array('NotifyItAdmin', 'notify_section_cb'), 'notify');

        add_settings_field('notify_delay', 'Delay', array('NotifyItAdmin', 'notify_delay_setting'), 'notify', 'notify_section');
        add_settings_field('notify_msg', 'Message', array('NotifyItAdmin', 'notify_msg_setting'), 'notify', 'notify_section');
        add_settings_field('notify_bg', 'Background Color', array('NotifyItAdmin', 'notify_bg_setting'), 'notify', 'notify_section');
        add_settings_field('notify_effect', 'Appearance Effect', array('NotifyItAdmin', 'notify_effect_setting'), 'notify', 'notify_section');
    }

    public static function add_css_in_admin_panel()
    {
    ?>
        <style>
            .notify-wrap select {
                min-width: 180px;
            }
            .notify-wrap textarea {
                min-width: 350px;
            }
        </style>
    <?php
    }

    /**
     * Notifyit form
     */
    public static function display_notify_structure()
    {
    ?>
        <div class="notify-wrap">
            <form action="options.php" method="post">
                <?php settings_fields('notify_group'); ?>
                <?php do_settings_sections('notify'); ?>

                <input type="submit" name="submit" class="button-primary" value="Save Changes">
            </form>
            <br><br><br>
            <!-- <p>Created by <a href="https://github.com/nadim1992" target="_blank">Jahidur Nadim</a>. Thanks for using.</p> -->
        </div>
    <?php
    }

    public static function validate_settings($plugin_options)
    {
        // validation code here if needed
        return $plugin_options;
    }

    public static function notify_section_cb()
    {
        // have to code here if needed
    }

    public static function notify_get_option_value( $option_name )
    {
        if ( isset( self::$options[ $option_name] ) ) {
            return self::$options[ $option_name];
        }

        return '';
    }

    public static function notify_delay_setting()
    {
        echo '<input type="number" name="notify_options[notify_delay]" value="' . absint( self::notify_get_option_value( 'notify_delay' ) ) . '" class="regular-text">';
        echo '<p class="description">Use milliseconds, e.g. 1500 <em>(1000 milliseconds = 1 second)<em>.</p>';
    }

    public static function notify_msg_setting()
    {
        echo '<textarea name="notify_options[notify_msg]" rows="5">' . esc_textarea( self::notify_get_option_value( 'notify_msg' ) ) . '</textarea>';
        echo '<p class="description">The main message for the notification.</p>';
    }

    public static function notify_bg_setting()
    {
        echo '<input style="cursor:pointer;" type="color" name="notify_options[notify_bg]" value="' . esc_html( self::notify_get_option_value( 'notify_bg' ) ) . '">';
        echo '<p class="description">Notification background color.</p>';
    }

    public static function notify_effect_setting()
    {
        $effect = array('scale', 'slide', 'genie', 'jelly', 'flip', 'exploader', 'loadingcircle', 'cornerexpand', 'boxspinner', 'slidetop', 'attached', 'bouncyflip');
        $stored_eff = esc_html( self::notify_get_option_value( 'notify_effect' ) );

        $str = "<select name='notify_options[notify_effect]'>";
        foreach ($effect as $eff) {
            $selected = $stored_eff === $eff ? 'selected' : '';
            $str .= "<option $selected>$eff</option>";
        }
        $str .= "</select>";

        echo $str . '<p class="description">Notification animation style.</p>';
    }

}





