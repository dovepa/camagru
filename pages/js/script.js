

// scroll menu

$(window).scroll(function(){
  $(".menu").stop().animate({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "slow" );
});

// alert hide msg

$(document).ready(function(){
  $('a').click(function(){
    if(!($('.hide').is(':hidden'))){
    $('.hide').slideUp('1000');
}
});
});

