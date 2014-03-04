<?php

namespace MadeByDavid\WooCommerceMailChimpGroupHook;

class Plugin {
    
    const TRANSLATE_DOMAIN = 'madebydavid-woocommercemailchimpgrouphook';
    
    const COOKING_CLASS_CATEGORY_SLUG = "classes";
    const GIFT_VOUCHER_CATEGORY_SLUG = "giftvouchers"; 
    
    protected $orderId;
    
    function __construct() {
        
        add_action('init', array($this, 'init'), 0);
        
        add_action('woocommerce_order_status_changed', array($this, 'orderStatusChanged'), 0, 3);
        add_action('woocommerce_thankyou', array($this, 'orderStatusChanged'), 0, 1);
        
        add_filter('ss_wc_mailchimp_subscribe_merge_vars', array($this, 'determineMailchimpGroups'));
        
    }
    
    public function init(){
        
    }
    
    public function setOrderId($orderId) {
        $this->orderId = $orderId;
    }
    
    public function getOrderId() {
        return $this->orderId;
    }
    
    public function orderStatusChanged($id, $status = 'new', $new_status = 'pending' ) {
        $this->setOrderId($id);
    }
    
    public function determineMailchimpGroups($mergeVars) {

        $groups = array();
        
        $order = new \WC_Order($this->getOrderId());
        
        foreach ($order->get_items() as $id => $item) {
            
            if (false === ($categories = get_the_terms($item['product_id'], 'product_cat'))) {
                continue;
            }
            
            foreach ($categories as $category) {
                if (self::COOKING_CLASS_CATEGORY_SLUG == $category->slug) {
                    $groups[] = 'Sushi Lesson';
                }
                
                if (self::GIFT_VOUCHER_CATEGORY_SLUG == $category->slug) {
                    $groups[] = 'Gift Voucher';
                }
                
            }
            
        }
        
        $bookingType = '';
        foreach ($coupons = $order->get_used_coupons() as $couponCode) {
            $coupon = new \WC_Coupon($couponCode);
        
            if (null == ($type = get_post_meta($coupon->id, 'SocialVouchersType', true))) {
                continue;
            }
        
            $bookingType = str_replace(
                array('MadeByDavidVoucherProvider', 'AmazonLocal', 'LivingSocial', 'TimeOut'),
                array('', 'Amazon Local', 'Living Social', 'Time Out'), $type
            );
        
        }
        
        if (0 != strlen($bookingType)) {
            $groups[] = $bookingType;
        }
        
        
        if (0 != count($groups)) {
            $mergeVars['GROUPINGS'] = array(array(
                'name' => 'Customer Source',
                'groups' => implode(', ', $groups)
            ));
        }
        
        return $mergeVars;
    }
    
    

}
