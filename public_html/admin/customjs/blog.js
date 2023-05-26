$(document).ready(function() {

	var deleteContentId = new Array();

	$("textarea").jqte();

	$('body').on('click','.deleteBlog',function() {

		var current=$(this);
		var url=$('#delete_blog_url').val();
		var token=$('input[name=_token]').val();
		var id=current.attr('data');

	    swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this blog!",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonColor: '#DD6B55',
	        confirmButtonText: 'Yes, delete it!',
	        closeOnConfirm: false,
	        allowOutsideClick: true	      
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