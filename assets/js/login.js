jQuery(document).ready(function($) {

    $('#fb-login').click(function(e) {
        e.preventDefault();

        FB.init({
            appId: _settings.facebook.id,
            cookie: true,
            oauth: true
        });

        FB.Event.subscribe('auth.login', function(response) {
            window.location.reload();
        });
        
        FB.Event.subscribe('auth.logout', function(response) {
            window.location.reload();
        });

        FB.login();
    });

});