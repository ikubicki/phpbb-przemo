auth.google = {
    init: () => {
        var icon = $('<img name="google" />')
        icon.attr('src', 'modules/auth-google/icon.png')
        icon.on('click', () => auth.google.form())
        $('div.auth div.providers').append(icon)
    },
    form: () => {
        $(location).attr('hash', '#google');
        var form = $('div.auth form')
        form.html('')
        $('div.auth div.providers img').each((i, el) => {
            $(el).removeClass('current')
        })
        $('div.auth div.providers img[name=google]').addClass('current')
        console.log('auth-google')
    }
}