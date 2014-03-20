<?php

namespace MadeByDavid\WooCommerceMailChimpGroupHook;

class PluginAdmin {
    
    const ADMIN_SCRIPT_ID = 'madebydavid-woocommercemailchimpgrouphook-admin-javascript';
    const ADMIN_AJAX_ACTION = 'madebydavid-woocommercemailchimpgrouphook-admin-ajax-action';
    
    private $plugin;
    private $warningText;
    
    function __construct($plugin) { 
        
        if (!is_admin()) {
            return false;
        }
        
        $this->plugin = $plugin;
        
        /* priority must be low so that the booking plugin adds the menu first */
        add_action('admin_menu', array($this, 'registerAdminMenu'), 100);
        add_action('admin_head', array($this, 'registerAdminCss'));
        add_action('admin_init', array($this, 'registerAdminJavascript'));
        
        
        $this->registerAdminAjax();
    }
    
    
    public function showWarning() {
        if (0 == strlen($this->warningText)) {
            return;
        }
        $this->includeTemplate('woocommerce-mailchimp-grouphook-admin/admin-warning.php');
    }
    
    public function addWarning($text) {
        $this->warningText = $text;
    }
    
    public function getWarning() {
        return $this->warningText;
    }
    
    function registerAdminMenu() {
        $optionsPage = add_submenu_page(
            'woocommerce',
            __( 'Mailchimp Rules', Plugin::TRANSLATE_DOMAIN),
            __( 'Mailchimp Rules', Plugin::TRANSLATE_DOMAIN),
            'manage_woocommerce',
            Plugin::TRANSLATE_DOMAIN,
            array($this, 'showAdminOptions')
        );
        add_action('admin_print_scripts-' . $optionsPage, array($this, 'enqueueAdminJavascript'));
    }
    function registerAdminCss() {
        echo '<link rel="stylesheet" type="text/css" href="'.WOOCOMMERCE_MAILCHIMPGROUPHOOK_DIR.'css/admin.css"></link>';
    }
    
    function registerAdminJavascript() {
        wp_register_script(
            self::ADMIN_SCRIPT_ID,
            WOOCOMMERCE_MAILCHIMPGROUPHOOK_DIR . 'js/admin.js',
            array('jquery')
        );
    }
    
    function registerAdminAjax() {
        add_action(
            'wp_ajax_'.self::ADMIN_AJAX_ACTION,
            array($this, 'adminAjaxCallback')
        );
    }
    
    function adminAjaxCallback() {
        header( "Content-Type: application/json" );
    
        if (!current_user_can('manage_woocommerce')) {
            wp_die( __('You do not have sufficient permissions to access this page.'));
        }
    
        if (!wp_verify_nonce(sanitize_text_field($_POST['nonce']), self::ADMIN_SCRIPT_ID)) {
            echo json_encode(array('error' => __('Invalid nonce', Plugin::TRANSLATE_DOMAIN)));
            exit();
        }
        
        /* extract the real options from the POST into an array */
        parse_str($_POST['options'], $options);

        
        die();
            
    }
    
    function enqueueAdminJavascript() {
        wp_enqueue_script(self::ADMIN_SCRIPT_ID);
        /* need to manually enqueue these for non admin users */
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
        /* setup script variables for webservice */
        wp_localize_script(
            self::ADMIN_SCRIPT_ID,
            'WooCommerceBookingRescheduler',
            array(
                'webServiceUrl' => admin_url('admin-ajax.php'),
                'webServiceAction' => self::ADMIN_AJAX_ACTION,
                'webServiceNonce' => wp_create_nonce(self::ADMIN_SCRIPT_ID)
            )
        );
    }
    
    public function showAdminOptions() {
    
        if (!current_user_can('manage_woocommerce')) {
            wp_die( __('You do not have sufficient permissions to access this page.'));
        }
        
        $this->showWarning();
     
        $this->includeTemplate('woocommerce-mailchimp-grouphook-admin/admin-options.php', $this);
    }
    
    
    public function includeTemplate($templateName) {
        if (0 == strlen($template = locate_template($templateName))) {
            include WOOCOMMERCE_MAILCHIMPGROUPHOOK_DIR . '/templates/'.$templateName;
        } else {
            include $template;
        }
    }
    
    
}
