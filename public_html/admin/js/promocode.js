$(document).ready(function() {


	$('body').on('click','.changePromoCodeStatus',function() {

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

	$('body').on('click','.deletePromoCode',function() {

		var current=$(this);
		var url=$('#delete_promocode_url').val();
		var token=$('input[name=_token]').val();
		var id=current.attr('data');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this promocode details",
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
						swal("Deleted!", "Promocode has been successfully deleted!", "success");
					}
					else {
						swal("Error", "An error occurred while deleting promocode, Please try again later :)", "error");
					}
				}
			});
	      });
	});


    $('body').on('change','#changeCouponBasedOn',function(){

      var based_on=$(this).val();
      $('.userSelection').hide("slow");
      $('.productSelection').hide("slow");
      $('.categorySelection').hide("slow");
      if (based_on==1) {
        $('.userSelection').show("slow");
      }
      if (based_on==2) {
        $('.productSelection').show("slow");
      }
      if (based_on==3) {
        $('.categorySelection').show("slow");
      }

    });

    $('body').on('change','#discountType',function() {

        var discount_type=$(this).val();
        $('.flatDiscount').hide("slow");
        $('.percentageDiscount').hide("slow");        
        if (discount_type==1) {
          $('.flatDiscount').show("slow");
        }
        if (discount_type==2) {
          $('.percentageDiscount').show("slow");
        }

    });

});