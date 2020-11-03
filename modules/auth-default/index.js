auth.default = {
    init: () => {
        var icon = $('<img name="default" />')
        icon.attr('src', 'modules/auth-default/icon.png')
        icon.on('click', () => auth.default.form())
        $('div.auth div.providers').append(icon)
    },
    form: () => {
        $(location).attr('hash', '');
        var form = $('div.auth form')
        form.html('')
        $('div.auth div.providers img').each((i, el) => {
            $(el).removeClass('current')
        })
        $('div.auth div.providers img[name=default]').addClass('current')
        console.log('auth-default')
        
        form.attr('class', 'default');
        username = $('<input type="text" name="login" placeholder="'+auth.options.phrases.username+'" />')
        password = $('<input type="password" name="login" placeholder="********" />')
        submit = $('<input type="submit" value="'+auth.options.phrases.signin+'" />')
        remember = $('<label><input type="checkbox" name="remember" value="1" /> '+auth.options.phrases.rememberme+'</label>')

        form.append(username)
        form.append(password)
        form.append(submit)
        form.append(remember)
    }
}