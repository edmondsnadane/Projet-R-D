/*(function($) {
    
   // $( "#nextButton" ).click(function() {
    //    $( ".cal-month-box" ).animate({ "left": "+=50px" }, "slow" );
    //});
 //  $( "#nextButton" ).click(function() {
//        console.log("toto");
//        $( "#calendar" ).css({"-webkit-transform":"translate(500px)"});
        //.animate({},400);
     //   .animate({  textIndent: 0 }, {
    //            step: function(now,fx) {
    //             $(this).css('-webkit-transform','rotate('+now+'deg)'); 
    //    },
    //    duration:'slow'
    //    },'linear');
 //   });
    
    
    
    var calendar = document.getElementById('calendar');
    //console.log(calendar);
    
    var options = {
        dragLockToAxis: true,
        dragBlockHorizontal: true
    };
    
    var hammertime = new Hammer(calendar, options);
    
    //hammertime.get('swipe').set({ direction: Hammer.DIRECTION_HORIZONTAL });
    
//    hammertime.on('swipe', function(ev) {
        //console.log(ev);
        //console.log(ev.velocityX);
//        if (ev.velocityX < 0) // < 0 -> vers la droite
//            $('#prevButton').click();
//        else // > 0 -> vers la gauche
//            $('#nextButton').click();
//    });
    
    hammertime.on("dragleft dragright swipeleft swiperight", function(event){

        console.log(event.deltaX);
        //$('#calendar').animate({translateX: '550px'}, 500);
        //backgroundElement.style.transform = 'translateX(' + event.deltaX + 'px)';
        
        if (event.deltaX < 0) { // < 0 -> vers la droite
            console.log("toto");
            $( "#prevButton" ).click();
            
        }    
            //$('#prevButton').click().transition({ x: "50" }, 200);
        else { // > 0 -> vers la gauche
            console.log("tata");
            $( "#nextButton" ).click();
            
            
            
        }    
            //$('#nextButton').click();
        
    });
}(Zepto));*/






(function($) {
    
    var calendar = $('#calendar');//document.getElementById('calendar');
    //var hammertime = new Hammer(calendar);
    console.log(calendar);
    //hammertime.on("dragleft dragright swipeleft swiperight", function(event){
    
    calendar.hammer().on("dragright swiperight", function(event){
        $( "#prevButton" ).click();
    });
    calendar.hammer().on("dragleft swipeleft", function(event){
        $( "#nextButton" ).click();
    });
    
    
    var boutonPanel = $('#panelCalendar');
    var panel = $('#panelFilter');
    var calendarContainer= $('#calendarContainer');
    var width = $(window).width();
    var count = 0;
    var count1 = 0;
    
    boutonPanel.click(function(){  
        if (count == 0)
        {
            console.log("show");
            //panel.css({"left":"0"}).animate({},500);
            panel.animate({
                left: "0px"
              }, 500 );
            calendarContainer.css({"opacity": "0.5"});
            count = 1;
            count1 = 1;
        }
        else
        {
            console.log("hide");
            //panel.css({"left":"-500"}).animate({},500);
            panel.animate({
                left: "-300px"
              }, 500 );
            calendarContainer.css({"opacity": "1"});
            count = 0;
            count1 = 0;
        }
    });
    var test1 = $('#headerProjet');
    var test2 = $('#calendarContainer');
    
   /* test1||test2.click(function(){
        console.log("test");
        panel.animate({
                left: "-300px"
              }, 500 );
            calendarContainer.css({"opacity": "1"});
    });*/
    
    if (count1 == 1)
    {
        console.log("count1");
        if (test1.click())
        {
        console.log("test1");
        }
        if (test2.click())
        {
        console.log("test2");
        }
    };
    
    
    /*if () {
        
    }*/
    //calendarContainer
    //footer
    /*var body = $('body');
    body.child.click(function(event){
        panel.animate({
                left: "-300px"
              }, 500 );
            calendarContainer.css({"opacity": "1"});
    }*/
    /*
   // var page = document.getElementById('divBackGround');//$('#calendarContainer');//
    var page = $('body');//$('#calendarContainer');
    console.log(page);
    
    page.hammer().on("swiperight", function(e){
        console.log('toto');
        //page.animate({translateX: "500px"}, 500);
       // page.css({"-webkit-transform":"translate(500px)"}).animate({},500);
    })
    
    page.hammer().on("swipeleft", function(e){
        console.log('tata');
        //page.animate({translateX: "500px"}, 500);
        //page.css({"-webkit-transform":"translate(-500px)"});
    })
    
   // var hammerPanel = new Hammer($page);
    //console.log(hammerPanel);
    /*
    hammerPanel.on("swiperight", function(e){
        console.log('toto');
        page.animate({translateX: "500px"}, 500);
    });
    */
    
}(jQuery));