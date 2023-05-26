$(document).ready(function() {

  	$('#brand_id').searchableOptionList();
  	$('#color_id').searchableOptionList();

	$('body').on('click','.deleteVariationDB',function() {

		var current=$(this);
		var url=$('#delete_variation_url').val();
		var token=$('input[name=_token]').val();
		var id=current.attr('data');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this variation!",
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
						current.parent().parent().remove();
						swal("Deleted!", "Variation has been successfully deleted!", "success");
					}
					else {
						swal("Error", "An error occurred while deleting variation, Please try again later :)", "error");
					}
				}
			});
	      });


	});

	$('body').on('click','.deleteProductImage',function() {

		var current=$(this);
		var url=$('#delete_image_url').val();
		var token=$('input[name=_token]').val();
		var id=current.parent().parent().find('.multiImage').attr('data');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this image!",
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
						current.parent().parent().remove();
						swal("Deleted!", "Image has been successfully deleted!", "success");
					    var numItems = $('.multiImage').length;
					    numItems=numItems*136;
						$('.imageGroup').css("width",numItems+'px');					
					}
					else {
						swal("Error", "An error occurred while deleting image, Please try again later :)", "error");
					}
				}
			});
	      });
	});


	$('body').on('click','.deleteProductFooterImage',function() {

		var current=$(this);
		var url=$('#delete_footer_image_url').val();
		var token=$('input[name=_token]').val();
		var id=current.parent().parent().find('.multiImage').attr('data');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this image!",
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
						current.parent().parent().remove();
						swal("Deleted!", "Image has been successfully deleted!", "success");
					    var numItems = $('.multiImage').length;
					    numItems=numItems*136;
						$('.imageGroup').css("width",numItems+'px');					
					}
					else {
						swal("Error", "An error occurred while deleting image, Please try again later :)", "error");
					}
				}
			});
	      });
	});

	$('body').on('click','.changeProductStatus',function() {

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

	$('body').on('click','.deleteProduct',function() {

		var current=$(this);
		var url=$('#delete_product_url').val();
		var token=$('input[name=_token]').val();
		var id=current.attr('data');

	      swal({
	        title: "Are you sure ?",
	        text: "You will not be able to recover this product",
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
						swal("Deleted!", "Product has been successfully deleted!", "success");
					}
					else {
						swal("Error", "An error occurred while deleting product, Please try again later :)", "error");
					}
				}
			});
	      });
	});

    $('body').on('click','.deleteProductDetailDB',function() {
      var numItems = $('.productDetailsDiv').length;
      var current=$(this);
      var id=current.attr('data-id');
      var url=$('#delete_product_specification_url').val();
      var token=$('input[name=_token]').val();
        swal({
          title: "Are you sure ?",
          text: "You will not be able to recover this product detail",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, delete it!',
          closeOnConfirm: false,
          allowOutsideClick: true,
        },
        function(){

        	$.ajax({
        		url:url,
        		data:'id='+id+'&_token='+token,
        		type:'POST',
        		success:function(data) {
        			if (data==1) {
			          
			          if(numItems==1){
			            current.parent().parent().parent().parent().remove();
			          }
			          else {
			            current.parent().parent().remove();

			          }
			          swal("Deleted!", "Product detail has been successfully deleted!", "success");

        			}
        			else {
			          	swal("Error!", "Error occurred while deleting product detail, Please try again later", "error");

        			}
        		}
        	});

        });


    });

  $('body').on('change', '#upload-file-multiple', function () {

      var reader = new FileReader();
      reader.onload = function(e) {
          CanvasCrop = $.CanvasCrop({
              cropBox : ".imageBoxMultiple",
              imgSrc : e.target.result,
              limitOver : 2
    
          });
          rot1 =0 ;
          ratio1 = 1;
      }
      reader.readAsDataURL(this.files[0]);
    
  });

	$('body').on('click','.removeProductImage',function() {
		var imageName=$(this).parent().parent().find('.multiImage').attr('value');
		$(this).parent().parent().remove();
	});

    $(".product_type").on("ifChanged", function() {

      if ($('#product_type').prop('checked')==true) {
        $('.Productvariation').show("slow");
      }
      else {
        $('.Productvariation').hide("slow");
      }

    });

    $('body').on('click','.addProductDetails',function() {

        $('.productDetailsInner').append('<div class="col-xs-12 productDetailsDiv"> <div class="col-xs-10 row"> <div class="col-xs-12 firstMargine row"> <div class="col-xs-6"> <label>Product Details Title English</label><span class="required">*</span> <input type="text" name="product_detail_title_english[]" class="form-control" placeholder="Ex: color" > </div> <div class="col-xs-6"> <label>Product Details Value English</label><span class="required">*</span> <input type="text" name="product_detail_value_english[]" class="form-control" placeholder="Ex: red" > </div> </div> <div class="col-xs-12 row"> <div class="col-xs-6"> <label>Product Details Title hindi</label><span class="required">*</span> <input type="text" name="product_detail_title_hindi[]" class="form-control" placeholder="Ex: color" > </div> <div class="col-xs-6"> <label>Product Details Value hindi</label><span class="required">*</span> <input type="text" name="product_detail_value_hindi[]" class="form-control" placeholder="Ex: red" > </div> </div> </div> <div class="col-xs-2 deleteProductDetailIcon" ><input type="hidden" name="product_detail_id[]"><a class="actionBtn deleteProductDetail" data-toogle="tooltip" title="Delete"><i class="fa fa-trash"></i></a> </div> </div>');
    });

    $('body').on('click','.addVariation',function() {

      $('.productVariations').append('<div class="col-xs-12" style="margin-bottom: 1%;"><div class="col-xs-4"><label>Variation Name</label><span class="required">*</span><input type="text" name="variation_name[]" class="form-control" placeholder="Ex: 5 Qty"></div><div class="col-xs-4"><label>Variation Price</label><span class="required">*</span><input type="text" name="variation_price[]" class="form-control" placeholder="Variation Price"></div><div class="col-xs-2"> <label>Variation Order</label><span class="required">*</span><input type="text" name="variation_order[]" class="form-control" placeholder="Ex: 1"></div><input type="hidden" name="product_variation_id[]"><div class="col-xs-1"><label>Action</label><a class="actionBtn deleteVariation" data-toogle="tooltip" title="Delete"><i class="fa fa-trash"></i></a></div></div>');

    });

    $('body').on('click','.deleteProductDetail',function() {
      var numItems = $('.productDetailsDiv').length;

      var current=$(this);
        swal({
          title: "Are you sure ?",
          text: "You will not be able to recover this product detail",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, delete it!',
          closeOnConfirm: false,
          allowOutsideClick: true,
        },
        function(){
          if(numItems==1){
            current.parent().parent().parent().parent().remove();
          }
          else {
            current.parent().parent().remove();

          }
          swal("Deleted!", "Product detail has been successfully deleted!", "success");
        });


    });

    $('body').on('click','.deleteVariation',function() {
      var current=$(this);
        swal({
          title: "Are you sure ?",
          text: "You will not be able to recover this variation!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, delete it!',
          closeOnConfirm: false,
          allowOutsideClick: true,
        },
        function(){
          current.parent().parent().remove();
          swal("Deleted!", "Variation has been successfully deleted!", "success");
        });
    
    });

});