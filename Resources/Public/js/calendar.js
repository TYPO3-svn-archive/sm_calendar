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

    $(".CalendarTogglerAll").click(function(){
        cals = $(".CalendarToggler");

        if ($(".CalendarTogglerAll").attr('rel') == 1){

            $.each(cals, function(key, value) {
                var id = $(this).attr('rel');

                $(".calendar_"+id).show();
                $("#Calendar_"+id).removeClass('disabled');
                newStyle = $("#Calendar_"+id+" .bubbel").attr('rel');
                $("#Calendar_"+id+" .bubbel").attr('style', newStyle);
                $.cookie('calendar_'+id, 0); // set cookie
            });
            $(".CalendarTogglerAll").attr('rel', 0);

        } else {

            $.each(cals, function(key, value) {
                var id = $(this).attr('rel');

                $(".calendar_"+id).hide();
                $("#Calendar_"+id).addClass('disabled');
                oldStyle = $("#Calendar_"+id+" .bubbel").attr('style');
                $("#Calendar_"+id+" .bubbel").attr('style', '');
                $("#Calendar_"+id+" .bubbel").attr('rel', oldStyle);
                $.cookie('calendar_'+id, 1); // set cookie
            });
            $(".CalendarTogglerAll").attr('rel', 1);

        }

    });
});