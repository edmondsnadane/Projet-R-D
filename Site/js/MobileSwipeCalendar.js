(function($) {
    var calendar = $('#calendar');
    
    calendar.hammer().on("dragright swiperight", function(event){
        $( "#prevButton" ).click();
    });
    calendar.hammer().on("dragleft swipeleft", function(event){
        $( "#nextButton" ).click();
    });
    
    var boutonPanel = $('#panelCalendar');
    var panel = $('#panelFilter');
    var calendarContainer= $('#calendarContainer');
    var count = 0;
    
    boutonPanel.click(function(){  
        if (count == 0)
        {
            panel.animate({
                left: "0px"
              }, 500 );
            calendarContainer.css({"opacity": "0.5"});
            count = 1;
        }
        else
        {
            panel.animate({
                left: "-300px"
              }, 500 );
            calendarContainer.css({"opacity": "1"});
            count = 0;
        }
    });
}(jQuery));