auth.default = {
    init: () => {
        auth.icon('default', 'modules/auth-default/icon.png', auth.default.form)
    },
    form: () => {
        var fields = []
        fields.push($('<input type="text" name="login" placeholder="'+auth.options.phrases.username+'" />'))
        fields.push($('<input type="password" name="password" placeholder="********" />'))
        fields.push($('<input type="submit" value="'+auth.options.phrases.signin+'" />'))
        auth.form('default', fields)
    }
}