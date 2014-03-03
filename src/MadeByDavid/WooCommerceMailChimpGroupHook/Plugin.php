<?php

namespace MadeByDavid\WooCommerceMailChimpGroupHook;

class Plugin {
    
    const TRANSLATE_DOMAIN = 'madebydavid-woocommercemailchimpgrouphook';

    
    function __construct() {
        
        add_action('init', array($this, 'init'), 0);
        

    }
    
    public function init(){
        
    }
    
       
    

}
