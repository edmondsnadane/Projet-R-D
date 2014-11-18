(function($) {
    var calendar = document.getElementById('calendar');
    //console.log(calendar);
    var hammertime = new Hammer(calendar);
    
    hammertime.get('swipe').set({ direction: Hammer.DIRECTION_HORIZONTAL });
    
    hammertime.on('swipe', function(ev) {
        //console.log(ev);
        if (ev.velocityX < 0) // < 0 -> vers la droite
        {
            $('#nextButton').click();            
        }
        else // > 0 -> vers la gauche
        {
            $('#prevButton').click();
        }
       //console.log(ev.velocityX);
    });   
}(jQuery));