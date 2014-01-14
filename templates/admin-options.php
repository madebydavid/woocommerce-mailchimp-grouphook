<div class="wrap">
    <?php screen_icon('basket-item-metadata'); ?>
    <h2>Basket Item Meta Data Settings</h2>
    <p>Select the catageory of products which you would like the meta data field restricted to.</p>
    <p>If no category is selected then the field will be displayed for all products.</p>
    <p>If no Item Meta Data Name is specified then the field will not be displayed.</p>
    <form id="mbd_wcbimd_admin_form" method="post" action="options.php">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Item Meta Data Category</th>
                <td>
                    <select id="itemMetaDataCategory" name="itemMetaDataCategory">
                        <option value="">Please select</option>
                        <?php foreach ($categories = $this->getProductCategories() as $category): ?>
                            <option value="<?php echo $category->term_id?>" 
                                <?php echo ($category->term_id == $this->plugin->getConfiguration()->getShowMetaDataProductCategoryID()) ? "selected='selected'" : "" ?>><?php echo $category->name?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Item Meta Data Name</th>
                <td>
                    <input type="text" id="itemMetaDataName" name="itemMetaDataName" value="<?php echo $this->plugin->getConfiguration()->getMetaDataName(); ?>" />
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>
