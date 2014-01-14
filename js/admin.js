

jQuery(document).ready(function($) { 
    
    $('#mbd_wcbimd_admin_form').submit(function(e) {

        e.preventDefault();
        $.post(
            WooCommerceBasketItemMetaData.webServiceUrl,
            {
                'action': WooCommerceBasketItemMetaData.webServiceAction,
                'nonce': WooCommerceBasketItemMetaData.webServiceNonce,
                'options': $( this ).serialize() 
            },
            function(response) {
                WooCommerceBasketItemMetaData_displayPointerMessage('Changes Saved', $);
                
                     
                if (response.error) {
                                
                }
          }
                
        );    
        
        
    })
    
    
});


function WooCommerceBasketItemMetaData_displayPointerMessage(message, $) {

    $('#wpadminbar').pointer({
        content: '<h3>WooCommerce Basket Item Meta Data</h3><p>' + message + '</p>',
        position: {
            my: 'left top',
            at: 'center bottom',
            offset: '-25 0'
        },
        close: function() {
            
        }
    }).pointer('open');

}
