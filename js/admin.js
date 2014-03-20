

jQuery(document).ready(function($) { 
    
    $('#mbd_wcbr_admin_form').submit(function(e) {

        e.preventDefault();
        $.post(
            WooCommerceBookingRescheduler.webServiceUrl,
            {
                'action': WooCommerceBookingRescheduler.webServiceAction,
                'nonce': WooCommerceBookingRescheduler.webServiceNonce,
                'options': $( this ).serialize() 
            },
            function(response) {
                WooCommerceBookingRescheduler_displayPointerMessage('Changes Saved', $);
                     
                if (response.error) {
                                
                }
          }
                
        );    
        
        
    })
    
    $('input.colourPicker').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val("#" + hex);
            $(el).ColorPickerHide();
        },
        onBeforeShow: function () {
            $(this).ColorPickerSetColor(this.value.replace(/#/, ''));
        }
    }).bind('keyup', function(){
        $(this).ColorPickerSetColor(this.value.replace(/#/, ''));
    });
    
    
    
});


function WooCommerceBookingRescheduler_displayPointerMessage(message, $) {

    $('#wpadminbar').pointer({
        content: '<h3>WooCommerce Booking Rescheduler</h3><p>' + message + '</p>',
        position: {
            my: 'left top',
            at: 'center bottom',
            offset: '-25 0'
        },
        close: function() {
            
        }
    }).pointer('open');

}
