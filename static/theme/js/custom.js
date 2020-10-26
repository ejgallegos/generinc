$(function() {
   $("form").keypress(function(e) {
     var key;
     if(window.event)
      key=window.event.keyCode;
     else
       key=e.which;
     return(key != 13);
    });
   });
