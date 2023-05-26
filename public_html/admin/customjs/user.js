$('body').on('click','.deleteUser',function() {
    var current=$(this);
    var url=$('#delete_user_url').val();
    var token=$('input[name=_token]').val();
    var id=current.attr('data');

      swal({
        title: "Are you sure ?",
        text: "You will not be able to recover this user!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false,
        allowOutsideClick: true,
        //closeOnCancel: false
      },
      function(){
        var token=$('input[name=_token]').val();
        $.ajax({
            url:url,
            data:'id='+id+'&_token='+token,
            type:'post',
            success:function(data) {
                if (data.success == 1) {
                    deleteResponsiveDatatableRow(current,"#example2");
                    swal("Deleted!", "User has been successfully deleted!", "success");
                }
                else {
                    swal("Error", "An error occurred while deleting user, Please try again later :)", "error");
                }
            }
        });
      });
});