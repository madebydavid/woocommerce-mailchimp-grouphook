<div class="wrap">
    <?php screen_icon('woocommerce-mailchimp-grouphook'); ?>
    
    <h2>Mailchimp Rules</h2>
    
    <form id="mbd_wcbr_admin_form" method="post" action="options.php">
    
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Reshedule Period Days</th>
                <td><input type="text" name="reschedulePeriodDays" value="" /></td>
            </tr>
        </table>
        
        <div id="blocklyDiv" style="height: 480px; width: 600px;"></div>
        <xml id="toolbox" style="display: none">
            <block type="controls_if"></block>
            <block type="controls_repeat_ext"></block>
            <block type="logic_compare"></block>
            <block type="math_number"></block>
            <block type="text"></block>
            <block type="text_length"></block>
            <block type="property_check"></block>
            <block type="variables_get"></block>
        </xml>
          
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>
