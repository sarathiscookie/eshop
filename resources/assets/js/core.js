$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".deleteUser").on('click', function(){
        $.post('/admin/users/destroy', {userID: $(this).data("id")}, function(data){
        });
    });

});
