$(document).ready(function() {

  $('#my-select').searchableOptionList();


	$('body').on('change','#upload-image',function() {
	  readURL(this);
	});

  $('.my-select').searchableOptionList();
  $(".datetimepicker").datetimepicker({
    format: 'DD-MM-YYYY hh:mm A'
  });


  $('#example1,#example2,#example3,#example4,#example5,#example6,#example7,#example8,#example9,#example10').DataTable();

  $('.jqte-test').jqte();
  
  var jqteStatus = true;
  $(".status").click(function()
  {
    jqteStatus = jqteStatus ? false : true;
    $('textarea').jqte({"status" : jqteStatus})
  });
  $('[data-toggle="tooltip"]').tooltip();  

  //iCheck for checkbox and radio inputs
  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass   : 'iradio_minimal-blue'
  });

  $('#checkbox1').mousedown(function() {
    if (!$(this).is(':checked')) {
        this.checked = confirm("Are you sure?");
        $(this).trigger("change");
    }
  });

});
function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#show-image').attr('src', e.target.result);
      $('.imageGroup').show();
    }

    reader.readAsDataURL(input.files[0]);
  }
}

function deleteResponsiveDatatableRow(current,tableid) {
    var table = $(tableid).DataTable();
    var row;
    if(current.closest('table').hasClass("collapsed")) {
      var child = current.parents("tr.child");
      row = $(child).prevAll(".parent");
    } else {
      row = current.parents('tr');
    }
    table.row(row).remove().draw();
}