<?php

namespace MadeByDavid\WooCommerceBasketItemMetaData;

class PluginConfiguration {
    
    const OPTION_NAME_PREFIX = 'MBD\\WCBIMD';
    const OPTION_NAME_SELFISH_CATEGORY_ID = 'selfish_cat_id';
    
    public function buildOptionName($optionName) {
        return implode('::', array(
            PluginConfiguration::OPTION_NAME_PREFIX,
            $optionName
        ));
    }
    
    public function getSelfishCategoryID() {
        return get_option(
            self::buildOptionName(self::OPTION_NAME_SELFISH_CATEGORY_ID),
            null
        );
    }
    
    public function setSelfishCategoryID($categoryID) {
        return update_option(
            self::buildOptionName(self::OPTION_NAME_SELFISH_CATEGORY_ID),
            $categoryID
        );
    }
    
}
