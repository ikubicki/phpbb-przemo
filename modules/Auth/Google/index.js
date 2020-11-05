auth.google = {
    sdk: null,
    init: () => {  
        if (auth.options.gclient) {
            auth.google.gInit()
            auth.icon('google', 'modules/Auth/Google/icon.png', auth.google.form)
        }
    },
    form: () => {
        var fields = []
        var submit = $('<input type="submit" value="'+auth.options.phrases.signin_google+'" />')
        auth.google.onclick(submit)
        auth.form('google', [submit])
    },
    gInit: () => {
        console.log('-', gapi)
        gapi.load('auth2', function() {
            auth.google.sdk = gapi.auth2.init({
                client_id: auth.options.gclient
            });
        })
    },
    gcallback: (object, response) => {
        if (response.error) {
            auth.errors.push(response.error)
            auth.google.form()
            return
        }
        if (response.wc && response.wc.id_token) {
            var a = $('<input type="hidden" name="g[a]" value="" />')
            var t = $('<input type="hidden" name="g[t]" value="" />')
            a.val(response.Ca)
            t.val(response.wc.id_token)
            object.after(a)
            object.after(t)
            
            var form = object.parents('form')
            if (form.length) {
                form.submit()
            }
        }
    },
    onclick: (object) => {
        object.on('click', (e) => {
            if (auth.google.sdk) {
                auth.google.sdk.signIn({scope: 'profile email'}).then((response) => {
                    auth.google.gcallback(object, response)
                }).catch((response) => {
                    // auth.google.gcallback(object, response)
                })
            }
            e.preventDefault()
        })
    }
}