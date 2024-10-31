<?php

class NotifyFront {

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
        self::$options = get_option('notify_options');
        add_action('wp_enqueue_scripts', array('NotifyFront', 'add_style_script_frontend'));        
        add_action('wp_head', array('NotifyFront', 'add_style_frontend'));
    }
    
    public static function add_style_script_frontend()
    {
        wp_enqueue_style('notify_default', NOTIFYIT_PLUGIN_URL . 'css/ns-style.min.css', array(), NOTIFYIT_VERSION);

        wp_enqueue_script('notify_modernizer', NOTIFYIT_PLUGIN_URL . 'js/modernizr.custom.js', array(), NOTIFYIT_VERSION, false);
        wp_enqueue_script('notify_classie', NOTIFYIT_PLUGIN_URL . 'js/classie.js', array(), NOTIFYIT_VERSION, true);
        wp_enqueue_script('notify_notificationFx', NOTIFYIT_PLUGIN_URL . 'js/notificationFx.js', array(), NOTIFYIT_VERSION, true);
        wp_enqueue_script('notify_script', NOTIFYIT_PLUGIN_URL . 'js/script.js', array(), NOTIFYIT_VERSION, true);

        if ( self::$options ) {
            wp_localize_script('notify_script', 'notify_options', self::$options); 
        }
    }

    public static function add_style_frontend()
    {
        if ( self::$options ) {
            return;
        }
    ?>
        <style>
            div[class*=" ns-effect-"] {
                background: <?= isset( self::$options['notify_bg'] ) ? self::$options['notify_bg'] : '#f3f3f3'; ?>;
                color: #f1f1f1 !important;
            }
            div[class*=" ns-effect-"] a {
                color: #f3f3f3 !important;
            }
        </style>
    <?php
    }
}
