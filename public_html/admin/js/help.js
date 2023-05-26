$(document).ready(function() {
	$('body').on('click','.changeHelpStatus',function() {

		var current=$(this);
		var active_flag=current.attr('data-flag');
		var url=$('#help_status_change_url').val();
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


});