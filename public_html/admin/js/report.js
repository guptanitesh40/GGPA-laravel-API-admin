$(document).ready(function() {
  var report_data=$('#report_data').val();
  var report=$.parseJSON( report_data );
  
  $('#jqChart').jqChart({
      title: { text: 'Sales report Data' },
      animation: { duration: 1 },
      shadows: {
          enabled: true
      },
      series: [
          {
              type: 'column',
              data: report
          }
      ]
  });

  $('#datepicker1').datepicker({
    format:'dd-mm-yyyy'
  });
  $('#datepicker2').datepicker({
    format:'dd-mm-yyyy'
  });

});