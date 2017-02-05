$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#updateBuyerProfile").on('click', function(){
        var name     = $.trim($('#name').val());
        var lastname = $.trim($('#lastname').val());
        var address  = $.trim($('#address').val());
        var pincode  = $.trim($('#pincode').val());
        var phone    = $.trim($('#phone').val());

        $.post('/buyer/profile/edit', {name: name, lastname: lastname, address: address, pincode: pincode, phone: phone}, function(response){
            $(".showMessage").html('<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.profileBuyerUpdated+'</div>')
            response.user.name     = $('#name').val();
            response.user.lastname = $('#lastname').val();
            response.user.address  = $('#address').val();
            response.user.pincode  = $('#pincode').val();
            response.user.phone    = $('#phone').val();
        });
    });
});
