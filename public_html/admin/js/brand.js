$(document).ready(function() {

	$('body').on('click','.deleteBrand',function() {

		var current=$(this);
		var url=$('#brand_delete_url').val();
		var token=$('input[name=_token]').val();
		var id=current.attr('data-id');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this detail",
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
				data:'id='+id+'&_token='+token+'&active_flag=2',
				type:'post',
				success:function(data) {
					if (data==1) {
						deleteResponsiveDatatableRow(current,"#example2");
						swal("Deleted!", "Brand has been successfully deleted!", "success");
					}
					else {
						swal("Error", "An error occurred while deleting Brand, Please try again later :)", "error");
					}
				}
			});
	      });
	});

    $('body').on('click','.editBrand',function() {
      var id=$(this).attr('data-id');
      var name=$(this).attr('data-name');

      $('#edit_id').val(id);
      $('#edit_brand').val(name);
      $('#edit_id').val(id);
    });


});