<?php

namespace MadeByDavid\WooCommerceBasketItemMetaData;

class Plugin {
    
    const TRANSLATE_DOMAIN = 'madebydavid-woocommercebasketitemmetadata';
    
    private $configuration;
    private $admin;
    
    function __construct() {
        
        add_action('init', array($this, 'init'), 0);
        
        /* class to load the settings */
        $this->configuration = new PluginConfiguration();
        
        add_filter('woocommerce_add_cart_item_data', array($this, 'addItemMeta'), 10, 2);
        add_filter('woocommerce_get_cart_item_from_session', array($this, 'getCartItemFromSession'), 10, 2);
        add_filter('woocommerce_get_item_data',array($this, 'getOrderItemMeta'), 10, 2);
        add_action('woocommerce_add_order_item_meta', array($this, 'addOrderItemMeta'), 10, 2);
        
        
        if (is_admin()) {
            $this->admin = new PluginAdmin($this);
        }
        
    }
    
    public function init(){
        
    }
    

    function addOrderItemMeta($itemId, $cartItem) {
        if (isset($cartItem['TESTING'])) {
            woocommerce_add_order_item_meta( $itemId, 'SOMETHING', $cartItem['TESTING'] );
        }
    }
    
    function getOrderItemMeta($otherData, $cartItem) {
    
        if (isset($cartItem['TESTING'])) {
            error_log("setting");
            $otherData[] = array(
                    'name' => 'SOMETHING',
                    'value'=> $cartItem['TESTING'],
                    'display' => 'yes'
            );
        }
    
        return $otherData;
    }
    
    function getCartItemFromSession($cartItem, $values) {
    
        if (isset($values['TESTING'])) {
            $cartItem['TESTING'] = $values['TESTING'];
        }
    
    
        return $cartItem;
    }
    
    function addItemMeta($itemMeta, $productId) {
    
    
        $itemMeta['TESTING'] = $_POST['meta-test'];
        return $itemMeta;
    }
    
    private function isASelfishProduct($productId) {
        
        if (false === ($categories = get_the_terms($productId, 'product_cat'))) {
            return false;
        }
        
        foreach ($categories as $category) {
            if ($this->getConfiguration()->getSelfishCategoryID() == $category->term_id) {
                return true;
            }
        }
        
        return false;
    }
    
    public function getConfiguration() {
        return $this->configuration;
    }
    

}
