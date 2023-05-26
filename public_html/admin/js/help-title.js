$(document).ready(function() {


	$('body').on('click','.changeHelpTitleStatus',function() {

		var current=$(this);
		var active_flag=current.attr('data-flag');
		var url=$('#help_title_status_change_url').val();
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
						current.attr('data-original-title',"Active issue");
					}
					else if(new_flag==0) {
						current.css({'color':'red'});
						current.attr('data-flag',new_flag);
						current.attr('data-original-title',"Closed issue");
					}
				}
				else {
					swal("Error", "An error occurred while changing user status, Please try again later :)", "error");
				}
			}
		});

	});

	$('body').on('click','.deleteHelpText',function() {

		var current=$(this);
		var url=$('#help_title_status_delete_url').val();
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
						swal("Deleted!", "Help title has been successfully deleted!", "success");
					}
					else {
						swal("Error", "An error occurred while deleting help title, Please try again later :)", "error");
					}
				}
			});
	      });
	});

    $('body').on('click','.editHelpText',function() {
      var id=$(this).attr('data-id');
      var title_english=$(this).attr('data-title-english');
      var title_hindi=$(this).attr('data-title-hindi');

      // alert(id+'  '+title_english+'  '+title_hindi);
      $('#edit_title_english').val(title_english);
      $('#edit_title_hindi').val(title_hindi);      
      $('#edit_id').val(id);
    });

});