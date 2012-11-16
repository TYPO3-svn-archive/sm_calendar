$(document).ready(function(){
    $(".appointment").tooltip().dynamic({ bottom: { direction: 'down', bounce: true } });;

    cals = $(".CalendarToggler");
    $.each(cals, function(key, value) {
        var id = $(this).attr('rel');
        cookie = $.cookie('calendar_'+id);

        if (cookie == 1){
            $(".calendar_"+id).hide();
            $("#Calendar_"+id).addClass('disabled');
            oldStyle = $("#Calendar_"+id+" .bubbel").attr('style');
            $("#Calendar_"+id+" .bubbel").attr('style', '');
            $("#Calendar_"+id+" .bubbel").attr('rel', oldStyle);
        }
    });

    $(".CalendarToggler").click(function(){
        var id = $(this).attr("rel");
        if ($(this).hasClass('disabled')){
            $(this).removeClass('disabled');
            var cookie = 0;
            newStyle = $("#Calendar_"+id+" .bubbel").attr('rel');
            $("#Calendar_"+id+" .bubbel").attr('rel', '');
            $("#Calendar_"+id+" .bubbel").attr('style', newStyle);
        } else {
            $(this).addClass('disabled');
            oldStyle = $("#Calendar_"+id+" .bubbel").attr('style');
            $("#Calendar_"+id+" .bubbel").attr('style', '');
            $("#Calendar_"+id+" .bubbel").attr('rel', oldStyle);
            var cookie = 1;
        }
        $.cookie('calendar_'+id, cookie); // set cookie
        $(".calendar_"+id).fadeToggle(function(){
        });
    });
});