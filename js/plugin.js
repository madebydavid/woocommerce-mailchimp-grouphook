

jQuery(document).ready(function($) {
    
    
    
    
    $(document).on('click', '#reschedule', function(event) {
        event.preventDefault();
        
        $.post(
            WooCommerceBookingRescheduler.webServiceUrl,
            {
                'action': WooCommerceBookingRescheduler.webServiceAction,
                'nonce': WooCommerceBookingRescheduler.webServiceNonce,
                'reschedule': $('#rescheduleForm').serialize() 
            },
            function(response) {
                if (response.error) {
                    $('#reschedule_error').text(response.error).show();
                } else {
                    if ("Rescheduled" == response.status) {
                        window.location.href = response.rescheduledPageUrl;
                    } else {
                        $('#reschedule_error').text("Unexpected status returned : " + response.status).show();
                    }
                }
            },
            'json'
        );
            
    });
    
    
    $(document).on('click', '.resendEmail', function(event) {
        event.preventDefault();
        
          $.post(
            WooCommerceBookingRescheduler.webServiceUrl,
            {
                'action': WooCommerceBookingRescheduler.webServiceActionResend,
                'nonce': WooCommerceBookingRescheduler.webServiceNonce,
                'booking': 'booking_id=' + $(this).data('bookingId') 
            },
            function(response) {
                if (response.status == 'Sent') {
                    $('#bookingResendMessage').html(
                        'The confirmation email for this booking has been resent to <strong>'+response.email+'</strong>. '
                    );
                } else {
                    $('#bookingResendMessage').text('Unexpected response - '+response);
                }
            },
            'json'
        );
    });
    
 
    
    
});


