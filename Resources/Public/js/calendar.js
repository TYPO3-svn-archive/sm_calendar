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


    //ugly²
    $(".CalendarTogglerAll").click(function(){
        var style;
        var allDisabled = 1;
        cals = $(".CalendarToggler");
        if ($(".CalendarTogglerAll").attr('rel') == 0){

            $.each(cals, function(key, value) {
                var id = $(this).attr('rel');
                if (!$("#Calendar_"+id).hasClass('disabled')){
                    $(".calendar_"+id).hide();
                    $("#Calendar_"+id).addClass('disabled');
                    style = $("#Calendar_"+id+" .bubbel").attr('style');
                    $("#Calendar_"+id+" .bubbel").attr('rel', style);
                    $("#Calendar_"+id+" .bubbel").attr('style', '');
                    $.cookie('calendar_'+id, 1); // set cookie
                    allDisabled = 0;
                }
            });
            //TODO: ugly
            if (allDisabled == 1){
                $.each(cals, function(key, value) {
                    var id = $(this).attr('rel');
                    if ($("#Calendar_"+id).hasClass('disabled')){
                        $(".calendar_"+id).show();
                        $("#Calendar_"+id).removeClass('disabled');
                        style = $("#Calendar_"+id+" .bubbel").attr('rel');
                        $("#Calendar_"+id+" .bubbel").attr('style', style);
                        $("#Calendar_"+id+" .bubbel").attr('rel', '');
                        $.cookie('calendar_'+id, 0); // set cookie
                    }
                });
                $(".CalendarTogglerAll").attr('rel', '0');
            } else {
                $(".CalendarTogglerAll").attr('rel', '1');
            }
        } else {

            $.each(cals, function(key, value) {
                var id = $(this).attr('rel');
                if ($("#Calendar_"+id).hasClass('disabled')){
                    $(".calendar_"+id).show();
                    $("#Calendar_"+id).removeClass('disabled');
                    style = $("#Calendar_"+id+" .bubbel").attr('rel');
                    $("#Calendar_"+id+" .bubbel").attr('style', style);
                    $("#Calendar_"+id+" .bubbel").attr('rel', '');
                    $.cookie('calendar_'+id, 0); // set cookie
                }
            });
            $(".CalendarTogglerAll").attr('rel', '0');

        }

    });
});