$(document).ready(function() {

  $('body').on('click','.openModelBtn',function() {

    $('#to_do_text').val('');
    $('#due_time').val('');
    $('#id').val('');

  });

  $( "#sortable" ).sortable({
    connectWith: ".connectedSortable",
    update:function() {
      var data = $(this).sortable('serialize');
      var url=$('#change_order_url').val();
      var token=$('input[name=_token]').val();

      $.ajax({
          data: data,
          type: 'GET',
          url: url,
          success:function(data) {

            if (data=='1') {

            }
            else {
              swal("Error", "An error occurred while arranging tasks, Please try again later :)", "error");
            }

          }

      });

    }
  }).disableSelection();

  $('body').on('click','.editFromToDoList',function() {

    var to_do_id_old=$(this).parent().parent().find('#to_do_id_old').val();   
    var due_time_old=$(this).parent().parent().find('#due_time_old').val();
    var to_do_text_old=$(this).parent().parent().find('.toDoText').text();

    $('#to_do_text').val(to_do_text_old);
    $('#due_time').val(due_time_old);
    $('#id').val(to_do_id_old);
    $('#myModal').modal('show');

  });

  $('body').on('click','.deleteFromToDoList',function() {

    var current=$(this);
    var id=current.parent().parent().find('input[type="checkbox"]').attr('value');
      swal({
        title: "Are you sure ?",
        text: "You will not be able to recover this task deatils!",
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
    var url=$('#change_task_status_url').val();
    // alert(url);
    $.ajax({
      url:url,
      data:'id='+id+'&_token='+token+'&status=2',
      type:'post',
      success:function(data) {
        if (data==1) {
          current.parent().parent().remove();
          swal("Deleted!", "Task has been successfully deleted!", "success");
        }
        else {
          swal("Error", "An error occurred while deleting task, Please try again later :)", "error");
        }
      }
    });
      });

  });

  $('.todo-list').todoList({
    onCheck  : function () {
      var token=$('input[name=_token]').val();
      var url=$('#change_task_status_url').val();
      var id=$(this).attr('value');
      $.ajax({
        url:url,
        data:'id='+id+'&_token='+token+'&status=0',
        type:'post',
        success:function(data) {
          if (data==1) {
            // $(row).remove();
            // current.parent().parent().parent().parent().remove();
            // swal("Deleted!", "Serviec has been successfully deleted!", "success");
          }
          else {
            swal("Error", "An error occurred while changing task status, Please try again later :)", "error");
          }
        }
      });
      // window.console.log($(this), 'The element has been checked');
    },
    onUnCheck: function () {
      // window.console.log($(this), 'The element has been unchecked');
      var token=$('input[name=_token]').val();
      var url=$('#change_task_status_url').val();
      var id=$(this).attr('value');
      $.ajax({
        url:url,
        data:'id='+id+'&_token='+token+'&status=1',
        type:'post',
        success:function(data) {
          if (data==1) {
            // $(row).remove();
            // current.parent().parent().parent().parent().remove();
            // swal("Deleted!", "Serviec has been successfully deleted!", "success");
          }
          else {
            swal("Error", "An error occurred while changing task status, Please try again later :)", "error");
          }
        }
      });

    }
  });

});