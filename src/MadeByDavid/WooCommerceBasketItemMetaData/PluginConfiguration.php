<?php

namespace MadeByDavid\WooCommerceBasketItemMetaData;

class PluginConfiguration {
    
    const OPTION_NAME_PREFIX = 'MBD\\WCBIMD';
    const OPTION_NAME_SHOW_META_DATA_CATEGORY_ID = 'meta_data_cat_id';
    const OPTION_NAME_META_DATA_NAME = 'meta_data_name';
    
    public function buildOptionName($optionName) {
        return implode('::', array(
            PluginConfiguration::OPTION_NAME_PREFIX,
            $optionName
        ));
    }
    
    public function getShowMetaDataProductCategoryID() {
        return get_option(
            self::buildOptionName(self::OPTION_NAME_SHOW_META_DATA_CATEGORY_ID),
            false
        );
    }
    
    public function setShowMetaDataProductCategoryID($categoryID) {
        return update_option(
            self::buildOptionName(self::OPTION_NAME_SHOW_META_DATA_CATEGORY_ID),
            $categoryID
        );
    }
    
    public function getMetaDataName() {
        return get_option(
            self::buildOptionName(self::OPTION_NAME_META_DATA_NAME),
            null
        );
    }
    
    public function setMetaDataName($name) {
        return update_option(
            self::buildOptionName(self::OPTION_NAME_META_DATA_NAME),
            $name
        );
    }
    
}
