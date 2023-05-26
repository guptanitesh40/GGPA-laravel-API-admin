$(document).ready(function(){
  $(".mobile_menu").click(function(){
    $(".mobile_nav").toggle();
  	if ($('.header').hasClass('active')) {
  		$('.header').removeClass('active')
  		$('.mobile_menu').text('☰');
  	}
  	else {
  		$('.header').addClass('active')  		
  		$('.mobile_menu').text('X');
  	}
  });
});

/////////////////////////////////////////////////// Home testimonial slider



