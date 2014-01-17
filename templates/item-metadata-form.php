
<label for="mbd_basketItemMetaData"><?php echo $itemMetaDataFieldName ?></label>

<input type="text" id="mbd_basketItemMetaData" name="<?php echo \MadeByDavid\WooCommerceBasketItemMetaData\Plugin::getFieldName(); ?>" value="<?php echo esc_attr(\MadeByDavid\WooCommerceBasketItemMetaData\Plugin::getLastPostedMetaDataValue()); ?>"/>
