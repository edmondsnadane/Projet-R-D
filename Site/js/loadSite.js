//(function($) {              
$(window).load(function() {
    
     if ($(location).attr('href') != "http://localhost/Projet-R-D/Site/index.php")
            {
                $('#panelCalendar').style.visibility = 'hidden';
                document.getElementById('panelCalendar').style.visibility = 'hidden';
                $('#panelCalendar').hide();
            }
            else
            {
                $('#panelCalendar').show();
            }
});
//}(jQuery));