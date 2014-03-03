<?php

namespace MadeByDavid\WooCommerceMailChimpGroupHook;

class Plugin {
    
    const TRANSLATE_DOMAIN = 'madebydavid-woocommercemailchimpgrouphook';

    
    function __construct() {
        
        add_action('init', array($this, 'init'), 0);
        
        add_action('woocommerce_order_status_changed', array($this, 'orderStatusChanged'), 0, 3);
        
        add_filter('ss_wc_mailchimp_subscribe_merge_vars', array($this, 'determineMailchimpGroups'));
        
    }
    
    public function init(){
        
    }
    
    
    public function orderStatusChanged($id, $status = 'new', $new_status = 'pending' ) {
       
        error_log("orderStatusChanged");
    }
    
    public function determineMailchimpGroups($mergeVars) {
        
        error_log("determineMailchimpGroups");
        
        return $mergeVars;
    }
    
    

}
