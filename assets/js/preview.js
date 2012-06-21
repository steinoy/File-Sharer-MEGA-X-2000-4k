(function ($) {
  
  if ($('.img').length) {

    _fit = false;

    $('img').load(function() {
      $('#preview').css('height', $(window).height()-40);
      $('.img img').imageFit('fit').css('margin', '0');
      $('#preview').css({
        'margin-top': '-'+$('.img img').height() / 2+'px',
        'margin-left': '-'+$('.img img').width() / 2+'px'
      });
    });
  	
  };
    
})(jQuery);