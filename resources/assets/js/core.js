$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* Update functionality for buyer */
    $("#updateBuyerProfile").on('click', function(){
        var name     = $.trim($('#name').val());
        var lastname = $.trim($('#lastname').val());
        var address  = $.trim($('#address').val());
        var pincode  = $.trim($('#pincode').val());
        var phone    = $.trim($('#phone').val());

        $.post('/seller/profile/edit', {name: name, lastname: lastname, address: address, pincode: pincode, phone: phone}, function(response){
            })
            .done(function(response) {
                $(".showMessage").show();
                $( '.showAlert' ).hide();
                $(".showMessage").html('<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.profileSellerUpdated+'</div>')
                response.user.name     = $('#name').val();
                response.user.lastname = $('#lastname').val();
                response.user.address  = $('#address').val();
                response.user.pincode  = $('#pincode').val();
                response.user.phone    = $('#phone').val();
            })
            .fail(function(response) {
                if( response.status === 422 ) {
                    $( '.showAlert' ).show();
                    $(".showMessage").hide();
                    //process validation errors here.
                    var errors = response.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each( errors , function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $( '.showAlert' ).html( errorsHtml );
                }
            });
    });


    /*Update functionality for seller*/
    $("#updateSellerProfile").on('click', function(){
        var name     = $.trim($('#name').val());
        var lastname = $.trim($('#lastname').val());
        var address  = $.trim($('#address').val());
        var pincode  = $.trim($('#pincode').val());
        var phone    = $.trim($('#phone').val());

        $.post('/seller/profile/edit', {name: name, lastname: lastname, address: address, pincode: pincode, phone: phone}, function(response){
        })
            .done(function(response) {
                $(".showMessage").show();
                $( '.showAlert' ).hide();
                $(".showMessage").html('<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.profileSellerUpdated+'</div>')
                response.user.name     = $('#name').val();
                response.user.lastname = $('#lastname').val();
                response.user.address  = $('#address').val();
                response.user.pincode  = $('#pincode').val();
                response.user.phone    = $('#phone').val();
            })
            .fail(function(response) {
                if( response.status === 422 ) {
                    $( '.showAlert' ).show();
                    $(".showMessage").hide();
                    //process validation errors here.
                    var errors = response.responseJSON;
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    $.each( errors , function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $( '.showAlert' ).html( errorsHtml );
                }
            });

    });

});
