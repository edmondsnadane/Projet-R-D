(function($) { 
    $(window).load(function() {

     var url = $(location).attr('href');
     var res = url.split("/");
     
     if (res.length == 6)
     {
          if (res[4] == "Site" && (res[5] == "index.php" || res[5] == ""))
               $('#panelCalendar').show();
          else
               $('#panelCalendar').hide();
     }
     else
          $('#panelCalendar').hide();
});
}(jQuery));