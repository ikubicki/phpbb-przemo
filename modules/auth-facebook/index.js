if (typeof auth == 'undefined') {
    var auth = {}
}

auth.facebook = {
    sdk: null,
    init: (options) => {
        window.fbAsyncInit = function() {
            auth.facebook.sdk = FB
            FB.init({
                appId: options.appid, cookie: true, xfbml: true, version: 'v4.0'
            });
            FB.AppEvents.logPageView();
        };

        ( function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        } (document, 'script', 'facebook-jssdk') );
    },
    callback: (selector, response) => {
        var reference = $(selector)
        if (response.status == 'connected') {
            var a = $('<input type="hidden" name="fb[a]" value="" />')
            var r = $('<input type="hidden" name="fb[r]" value="" />')
            var u = $('<input type="hidden" name="fb[u]" value="" />')
            a.val(response.authResponse.accessToken)
            r.val(response.authResponse.signedRequest)
            u.val(response.authResponse.userID)
            reference.after(a)
            reference.after(r)
            reference.after(u)
            var form = reference.parents('form')
            form.attr('action', '/modules/auth-facebook/auth-facebook.php');
            if (form.length) {
                form.submit()
            }
        }
    },
    onclick: (selector) => {
        $(selector).on('click', (e) => {
            auth.facebook.sdk.getLoginStatus(function(response) {
                auth.facebook.callback(selector, response)
            })
        })
    }
}