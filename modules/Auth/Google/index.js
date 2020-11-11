auth.Google = {
    sdk: null,
    init: (container) => {  
        if (auth.options.gclient) {
            auth.Google.gInit()
            auth.icon('Google', 'modules/Auth/Google/icon.png', auth.Google.form)
        }
    },
    form: () => {
        var fields = []
        var submit = $('<input type="submit" class="primary" value="'+(auth.options.phrases.sign_in_google || 'Sign in with Google')+'" />')
        auth.Google.onclick(submit, (response) => {
            var form = submit.parents('form')
            if (form.length) {
                form.submit()
            }
        })
        auth.form('Google', [submit])
    },
    signup: (container) => {
        if (auth.options.gclient) {
            auth.Google.gInit()
        }
        var form = $(container)
        var button = $('<input type="button" />')
        button.val(auth.options.phrases.sign_up_google || 'Sign up with Google')
        var options = $('<div class="options"></div>')
        options.append(button)
        form.append(options)
        auth.Google.onclick(button, (response) => {
            button.val(auth.options.phrases.google_connected || 'Google account connected')
            var username = form.find('input[name*=username]')
            if (!username.val()) {
                username.val(response.tt.Ad)
            }
        });
    },
    gInit: () => {
        gapi.load('auth2', function() {
            auth.Google.sdk = gapi.auth2.init({
                client_id: auth.options.gclient
            });
        })
    },
    gcallback: (object, response, callback) => {
        if (response.error) {
            auth.errors.push(response.error)
            auth.Google.form()
            return
        }
        if (response.tt && response.tt.dK) {
            var i = $('<input type="hidden" name="g[i]" value="" />')
            i.val(response.tt.dK)
            object.after(i)
        }
        if (response.wc && response.wc.id_token) {
            var a = $('<input type="hidden" name="g[a]" value="" />')
            var t = $('<input type="hidden" name="g[t]" value="" />')
            a.val(response.Ca)
            t.val(response.wc.id_token)
            object.after(a)
            object.after(t)

            if (callback) {
                callback(response)
            }
        }
    },
    onclick: (object, callback) => {
        object.on('click', (e) => {
            if (auth.Google.sdk) {
                auth.Google.sdk.signIn({scope: 'profile email'}).then((response) => {
                    auth.Google.gcallback(object, response, callback)
                }).catch((response) => {
                    console.debug(response)
                    // auth.Google.gcallback(object, response)
                })
            }
            e.preventDefault()
        })
    }
}