$(document).ready(function() {

    $(".changePassword").on("ifChanged", function() {

      if ($('#changePassword').prop('checked')==true) {
        $('.changePasswordDiv').show("slow");
      }
      else {
        $('.changePasswordDiv').hide("slow");
        $('#password').val('');
        $('#confirm_password').val();
      }

    });

    

});