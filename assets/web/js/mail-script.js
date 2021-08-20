    // -------   Mail Send ajax
    $(document).ready(function() {
        // form submit event
        $('#idContactForm').on('submit', function(e) {
            e.preventDefault(); // prevent default form submit
            let sClientName = $('#idClientName').val();
            let sClientEmail = $('#idClientEmail').val();
            let sEmailSubject = $('#idEmailSubject').val();
            let sEmailMsg = $('#idEmailMsg').val();
            let sActionUrl =  $(this).attr('action');
            $.ajax({
                url: sActionUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    name: sClientName,                 
                    email: sClientEmail,                 
                    subject: sEmailSubject,                 
                    message: sEmailMsg
                },
                beforeSend: function() {
                    $('.alert-msg').fadeOut();
                    $('.submit-btn').html('Sending....'); // change $('.submit-btn') button text
                },
                success: function(data) {
                    if(data.success){
                        $('.alert-msg').html(data.success).fadeIn();
                        $('#idContactForm').trigger('reset'); // reset form
                        $('.submit-btn').attr("style", "display: none !important");; // reset submit button text
                    }else if(data.error){
                        $('.alert-msg').html(data.error).fadeIn();
                        $('.submit-btn').html('Send Message');
                    }                    
                },
                error: function(e) {
                    console.log(e)
                }
            });
        });
    });

    // function mailTo(){
    //     let sClientName = $('#idClientName').val();
    //         let sClientEmail = $('#idClientEmail').val();
    //         let sEmailSubject = $('#idEmailSubject').val();
    //         let sEmailMsg = $('#idEmailMsg').val();
    //         console.log("sClientName :  ", sClientName);
    // }