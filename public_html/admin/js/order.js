$(document).ready(function() {

	$('body').on('click','.changeOrderStatus',function() {

		var url=$('#changeorderstatusurl').val();
		var token=$('input[name=_token]').val();
		var model=$(this).attr('data-model');
		var id=$(this).attr('data-id');
		var order_comment_english=$('#order_comment_english').val();
		var order_comment_hindi=$('#order_comment_hindi').val();	
		var order_status=$(this).attr('data-status');
		var current=$(this);

		var error=0;
		if (model=='1') {
			if (order_comment_english=="") {
				$("#order_comment_english").css("border","#ca0e0e 1px solid");
				error=1;
			}
			else {
				$("#order_comment_english").css("border","#d2d6de 1px solid");
			}
			if (order_comment_hindi=="") {
				$("#order_comment_hindi").css("border","#ca0e0e 1px solid");
				error=1;
			}
			else {
				$("#order_comment_hindi").css("border","#d2d6de 1px solid");
			}

			if (error==1) {
				return false;
			}
		}

      swal({
        title: "Are you sure ?",
        text: "You want to change this order status",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#2ba7e0',
        confirmButtonText: 'Yes, confirm it!',
        closeOnConfirm: true,
        allowOutsideClick: true,
        //closeOnCancel: false
      },
      function(){
      	$('#myModal').modal("hide");
      	$('.loader').show();
		$.ajax({
			url:url,
			data:'id='+id+'&_token='+token+'&order_status='+order_status+'&order_comment_english='+order_comment_english+'&order_comment_hindi='+order_comment_hindi,
			type:'post',
			success:function(data) {
				if (data==1) {
					location.reload();
					swal("Status changed!", "Order status has been changed successfully ", "success");

				}
				else {
					swal("Error", "An error occurred while changing order status, Please try again later :)", "error");
				}
		      	$('.loader').hide();

			}
		});
      });

	});

    $('body').on('click','.rejectedOrder',function() {

        var order_status=$(this).attr('data-status');
        var id=$(this).attr('data-id');

        $('.modelSubmitBtn').attr('data-id',id);
        $('.modelSubmitBtn').attr('data-status',order_status);

        $('#myModal').modal();

    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
           .columns.adjust()
           .responsive.recalc();
    });   

});