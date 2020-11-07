auth.classic = {
    container: null,
    init: (container) => {
        auth.icon('classic', 'modules/Auth/Classic/icon.png', auth.classic.form)
    },
    form: () => {
        var fields = []
        fields.push($('<input type="text" name="login" placeholder="'+(auth.options.phrases.username || 'Username')+'" />'))
        fields.push($('<input type="password" name="password" placeholder="********" />'))
        fields.push($('<input type="submit" class="primary" value="'+(auth.options.phrases.signin || 'Sign in')+'" />'))
        auth.form('classic', fields)
    }
}