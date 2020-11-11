auth.Classic = {
    container: null,
    init: (container) => {
        auth.icon('Classic', 'modules/Auth/Classic/icon.png', auth.Classic.form)
    },
    form: () => {
        var fields = []
        fields.push($('<input type="text" style="display: none" />'))
        fields.push($('<input type="password" style="display: none" />'))
        fields.push($('<input type="text" name="username" placeholder="'+(auth.options.phrases.username || 'Username')+'" />'))
        fields.push($('<input type="password" name="password" placeholder="'+(auth.options.phrases.password || 'Password')+'" />'))
        fields.push($('<input type="submit" class="primary" value="'+(auth.options.phrases.sign_in || 'Sign in')+'" />'))
        auth.form('Classic', fields)
    }
}