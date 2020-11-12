auth.Facebook = {
    sdk: null,
    init: (container) => {
        if (auth.options.fbappid) {
            auth.Facebook.fbInit()
            auth.icon('Facebook', basepath + '/modules/Auth/Facebook/icon.png', auth.Facebook.form)
        }
    },
    form: () => {
        var fields = []
        var submit = $('<input type="submit" class="primary" value="'+(auth.options.phrases.sign_in_facebook || 'Sign in with Facebook')+'" />')
        auth.Facebook.onclick(submit, (response) => {
            var form = submit.parents('form')
            if (form.length) {
                form.submit()
            }
        })
        auth.form('Facebook', [submit])
    },
    signup: (container) => {
        if (!auth.options.fbappid) {
            return
        }
        auth.Facebook.fbInit()
        var form = $(container)
        var button = $('<input type="button" />')
        button.val(auth.options.phrases.sign_up_facebook || 'Sign up with Facebook')
        var options = $('<div class="options"></div>')
        options.append(button)
        form.append(options)
        auth.Facebook.onclick(button, (response) => {
            // console.log(response)
            button.val(auth.options.phrases.facebook_connected || 'Facebook account connected')
            FB.api('/me', {fields: 'id,name,picture'}, function(response) {
                if (response.name) {
                    // console.log(response)
                    var i = $('<input type="hidden" name="fb[i]" value="" />')
                    i.val(response.picture.data.url)
                    button.after(i)
                    /*
                    form.find('input[name*=password]')
                        .attr('disabled', true)
                        .val('')
                    */
                    var username = form.find('input[name*=username]')
                    if (!username.val()) {
                        username.val(response.name)
                    }
                }
            });
        })        
    },
    fbInit: () => {
        window.fbAsyncInit = function() {
            auth.Facebook.sdk = FB
            FB.init({
                appId: auth.options.fbappid,
                cookie: true,
                xfbml: true,
                version: 'v8.0'
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
    fbcallback: (object, response, callback) => {
        if (response.status == 'connected') {
            var a = $('<input type="hidden" name="fb[a]" value="" />')
            var r = $('<input type="hidden" name="fb[r]" value="" />')
            var u = $('<input type="hidden" name="fb[u]" value="" />')
            a.val(response.authResponse.accessToken)
            r.val(response.authResponse.signedRequest)
            u.val(response.authResponse.userID)
            object.after(a)
            object.after(r)
            object.after(u)

            if (callback) {
                callback(response)
            }
        }
        else {
            console.debug(response)
            auth.errors.push('Unable to retrieve login details from Facebook')
            auth.Facebook.form()
        }
    },
    onclick: (object, callback) => {
        object.on('click', (e) => {
            auth.Facebook.sdk.getLoginStatus(function(response) {
                auth.Facebook.fbcallback(object, response, callback)
            })
            e.preventDefault()
        })
    }
}