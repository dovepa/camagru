

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

function scroll(){
var offset = 28;
$(window).scroll(function(){
  if ($(window).scrollTop() == $(document).height() - $(window).height() ){
    $.ajax({
      url : "ctrl.php?p=loader&off=" + offset,
      success: function(html){
      if (html){
        $(".post").append(html);
      };
      }
    });
    offset = offset + 28;
  }

});
}


function scrollh(){
  var offset = 10;
  $(window).scroll(function(){
    if ($(window).scrollTop() == $(document).height() - $(window).height() ){
      $.ajax({
        url : "ctrl.php?p=loader2&off=" + offset,
        success: function(html){
        if (html){
          $(".imgrp").append(html);
        };
        }
      });
      offset = offset + 10;
    }

  });
  }

  function scrollgal(id){
    var offset = 10;
    $(window).scroll(function(){
      if ($(window).scrollTop() == $(document).height() - $(window).height() ){
        $.ajax({
          url : "ctrl.php?p=loader3&off=" + offset + '&id=' + id,
          success: function(html){
            if (html){
              $(".imgrp").append(html);
            };
          }
        });
        offset = offset + 10;
      }

    });
    }

    function removepic(id) {
      if (confirm("Are you sure ?")){

          $.ajax({
            url : "ctrl.php?p=remove",
            type : "POST",
            data: 'item=' + id,
            dataType : 'html',
            success: function(html){
              if (html){
                alert(html);
              }else {
                alert(html);
              };
              $('#' + id).fadeOut("normal", function() {
             $(this).remove();});
            }
          });
      }else{
        alert('operation canceled');
      };
    }