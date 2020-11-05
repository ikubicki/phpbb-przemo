auth.classic = {
    init: () => {
        auth.icon('classic', 'modules/Auth/Classic/icon.png', auth.classic.form)
    },
    form: () => {
        var fields = []
        fields.push($('<input type="text" name="login" placeholder="'+auth.options.phrases.username+'" />'))
        fields.push($('<input type="password" name="password" placeholder="********" />'))
        fields.push($('<input type="submit" value="'+auth.options.phrases.signin+'" />'))
        auth.form('classic', fields)
    
    }
}