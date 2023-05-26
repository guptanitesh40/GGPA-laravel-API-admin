$(document).ready(function() {


	$('body').on('click','.changeCategoryStatus',function() {

		var current=$(this);
		var active_flag=current.attr('data-flag');
		var url=current.attr('data');
		var id=current.attr('data-id');
		var token=$('input[name=_token]').val();
		var new_flag=0;
		if (active_flag==0) {
			new_flag=1;
		}
		$.ajax({
			url:url,
			data:'id='+id+'&active_flag='+new_flag+'&_token='+token,
			type:'post',
			success:function(data) {
				if (data==1) {
					if (new_flag==1) {
						current.css({'color':'green'});
						current.attr('data-flag',new_flag);
						current.attr('data-original-title',"Disable");
					}
					else if(new_flag==0) {
						current.css({'color':'red'});
						current.attr('data-flag',new_flag);
						current.attr('data-original-title',"Enable");
					}
				}
				else {
					swal("Error", "An error occurred while changing status, Please try again later :)", "error");
				}
			}
		});

	});



	$('body').on('click','.deleteCategory',function() {

		var current=$(this);
		var url=$('#delete_category_url').val();
		var token=$('input[name=_token]').val();
		var id=current.attr('data');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this category and there products!",
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
					if (data==1) {
						deleteResponsiveDatatableRow(current,"#example2");
						swal("Deleted!", "Category has been successfully deleted!", "success");
					}
					else {
						swal("Error", "An error occurred while deleting category, Please try again later :)", "error");
					}
				}
			});
	      });
	});

});