var shouts = {
    options: {
        url: '/modules/shoutbox/shouts.php',
        selector: '#shouts',
        refresh: 5,
    },
    inputField: null,
    submitButton: null,
    tokenField: null,
    container: null,
    session: {},
    messages: [],
    latestId: 0,
    refreshCounts: 0,
    init: function (options) {
        this.options = Object.assign({}, this.options, options)
        this.run()
    },
    run: function() {
        context = $(this.options.selector)
        this.inputField = context.find('input[name=message]')
        this.submitButton = context.find('input[name=submit]')
        this.submitButton.on('click', this.submit)
        this.tokenField = context.find('input[name=token]')
        this.container = context.find('div.messages')
        this.refresh()
    },
    getInterval: function() {
        return this.options.refresh * 1000
    },
    refresh: function() {
        var data = {
            action: 'refresh',
            token: shouts.tokenField.val(),
            latestId: shouts.latestId
        }
        shouts.send(data)
        setInterval(this.refresh, shouts.getInterval())
    },
    submit: function(event) {
        var data = {
            action: 'submit',
            token: shouts.tokenField.val(),
            message: shouts.inputField.val(),
            latestId: shouts.latestId
        }
        shouts.send(data)
    },
    submitted: function(response) {
        shouts.refreshCounts++
        shouts.submitButton.attr('disabled', false)
        response = $.parseJSON(response)
        console.log(response, this)
        var newMessages = 0
        if (response) {
            if (response.token) {
                shouts.tokenField.val(response.token)
                shouts.inputField.val('')
            }
            if (response.session) {
                shouts.session = response.session
            }
            if (response.text) {
                shouts.inputField.val(response.text)
            }
            if (response.messages) {
                response.messages.forEach(message => {
                    if (!shouts.messages.includes(message.id)) {
                        var row = $('<p>' +
                            '<span class="author"><a href="' + message.author.url + '">' + message.author.name + '</a></span>' +
                            '<span class="text">' + message.text + '</span>' +
                            '<span class="time">' + message.time + '</span>' +
                            '</p>')
                        row.on('click', (event) => {
                            shouts.rowClick(event, message)
                        })
                        shouts.container.append(row)
                        shouts.messages.push(message.id)
                        newMessages++
                        if (message.id > shouts.latestId) {
                            shouts.latestId = message.id
                        }
                    }
                });
            }
            if (response.error) {
                if (shouts.container.find('p.error').length < 1) {
                    var errorRow = $('<p class="error">' + response.error + '</p>')
                    shouts.container.append(errorRow)
                    setInterval(() => {errorRow.fadeOut(300, () => {errorRow.remove()})}, (shouts.options.refresh * 3 - 1) * 1000)
                    newMessages++
                }
            }
            if (newMessages > 0) {
                shouts.container.scrollTop(shouts.container.prop('scrollHeight'));
            }
        }
    },
    rowClick: function(event, message) {
        var action = 'ref'
        if (message.author.id == shouts.session.id) {
            action = 'edit'
        }
        var data = {
            action,
            ref: message.id,
            text: message.text,
            token: shouts.tokenField.val(),
            latestId: shouts.latestId
        }
        shouts.send(data)
    },
    send: function(data, callback) {
        if (!callback) {
            callback = this.submitted
        }
        this.submitButton.attr('disabled', true)
        $.post(this.options.url, data, callback)
    }
    
}