(function ($) {

    if ($('img').length) {
        var height = $('img').height();
        var width = $('img').width();

        var maxWidth = $(window).width() - 40;
        var maxHeight= $(window).height() - 40;

        var ratio = height / width;

        if(width >= maxWidth && ratio <= 1){
            width = maxWidth;
            height = width * ratio;
        } else if(height >= maxHeight){
            height = maxHeight;
            width = height / ratio;
        }

        $('img').attr('width', width).attr('height', height);
        $('img').css('margin', -height/2+'px 0 0 '+-width/2+'px');
    };

})(jQuery);