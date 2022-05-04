$(window).scroll(function() {
    if ( $('#scroll-to').length) {
        var hT = $('#scroll-to').offset().top - $('#navigation-show').height(),
            wS = $(this).scrollTop(),
            left = $('.body').offset().left,
            top = $('#navigation-show').height() + 2;
        if (wS >= hT){
             $('#to-show').css('left', left);
             $('#to-show').css('top', top);
             $('#to-show').fadeIn();
        }
        else{
            if (wS < hT){
                $('#to-show').fadeOut();
           }
        }
    }
    
    var navPos =  $('#nav').offset().top,
        wSc = $(this).scrollTop(),
        leftNav = $('#nav').offset().left;
    if (navPos > wSc) {
        $('#navigation-show').hide();
    }
    if (navPos < wSc) {
        $('#navigation-show').css('left', leftNav);
        $('#navigation-show').css('width', $('.body').width());
        $('#navigation-show').fadeIn();
    }
});

$(window).resize(function(){
    if ($('#scroll-to').length) {
        var left = $('.body').offset().left + $('.body').width() - $('#to-show').width();
        $('#to-show').css('left', left);
    }
    var leftNav = $('#nav').offset().left;
    $('#navigation-show').css('left', leftNav);
});