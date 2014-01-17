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
        
        add_action('woocommerce_before_add_to_cart_button', array($this, 'showItemMetaDataField'), 100);
        
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
    
    function showItemMetaDataField() {
        
        global $product;
       
        if (false == $this->showForProduct($product->id)) {
            return;
        }
        
        if (0 == strlen($itemMetaDataFieldName = self::getMetaDataName())) {
            return;
        }
        
        if (0 == strlen($template = locate_template('item-metadata-form.php'))) {
            include WOOCOMMERCE_BASKETITEMMETADATA_DIR . '/templates/item-metadata-form.php';
        } else {
            include $template;
        }
        
    }

    static function getFieldName() {
        $config = new PluginConfiguration();
        return "mbd_bimd_".md5($config->getMetaDataName());
    }
        
    
    static function getLastPostedMetaDataValue() {
        return $_REQUEST[self::getFieldName()];
    }
    
    static function getMetaDataName() {
        static $configuration;
        if (null == $configuration) {
            $configuration = new PluginConfiguration();
        }
        return $configuration->getMetaDataName();
    }
    
    function addOrderItemMeta($itemId, $cartItem) {
        if (isset($cartItem[self::getMetaDataName()])) {
            woocommerce_add_order_item_meta(
                $itemId, self::getMetaDataName(), 
                $cartItem[self::getMetaDataName()] 
            );
        }
    }
    
    function getOrderItemMeta($otherData, $cartItem) {
    
        if (isset($cartItem[self::getMetaDataName()])) {
            $otherData[] = array(
                    'name' => self::getMetaDataName(),
                    'value'=> $cartItem[self::getMetaDataName()],
                    'display' => 'yes'
            );
        }
    
        return $otherData;
    }
    
    function getCartItemFromSession($cartItem, $values) {
    
        if (isset($values[self::getMetaDataName()])) {
            $cartItem[self::getMetaDataName()] = $values[self::getMetaDataName()];
        }
    
    
        return $cartItem;
    }
    
    function addItemMeta($itemMeta, $productId) {
        $itemMeta[self::getMetaDataName()] = $_POST[self::getFieldName()];
        return $itemMeta;
    }
    
    private function showForProduct($productId) {
        
        /* if no category set in admin then show for all products */
        if (false == ($showCategoryId = $this->getConfiguration()->getShowMetaDataProductCategoryID())) {
            return true;
        }
        
        /* if product has no categories then we wont be showing it */
        if (false === ($categories = get_the_terms($productId, 'product_cat'))) {
            return false;
        }
        
        foreach ($categories as $category) {
            if ($showCategoryId == $category->term_id) {
                return true;
            }
        }
        
        return false;
    }
    
    public function getConfiguration() {
        return $this->configuration;
    }
    

}
