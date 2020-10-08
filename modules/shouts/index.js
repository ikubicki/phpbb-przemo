var shouts = {
    options: {
        url: '/modules/shouts/shouts.php',
        selector: '#shouts',
        refresh: 5,
        langs: {
            submit: 'Submit',
            cancel: 'Cancel'
        }
    },
    inputField: null,
    submitButton: null,
    tokenField: null,
    container: null,
    session: {},
    messages: [],
    latestId: 0,
    refreshCounts: 0,
    enabled: true,
    smileys: [],
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
        this.loadSmileys()
        this.refresh()
    },
    loadSmileys: function() {
        $.getJSON('/js/ckeditor/plugins/emoji/emoji.json', (response) => {
            shouts.smileys = []
            limit = 83
            response.forEach(smiley => {
                if (smiley.group == 'people' && limit) {
                    shouts.smileys.push(smiley.symbol)
                    limit--
                }
            })
            var link = $('<a href="javascript:void(0)">' + response[0].symbol + '</a>')
            link.on('click', () => {
                shouts.listSmileys()
            })
            this.inputField.after(link)
        })
    },
    listSmileys: function() {
        var smileysContainer = $(this.options.selector).find('div.smileys')
        if (smileysContainer.length > 0) {
            smileysContainer.remove()
            return
        }
        smileysContainer = $('<div class="smileys"></div>')
        this.submitButton.after(smileysContainer)

        shouts.smileys.forEach(smiley => {
            var item = $('<a href="javascript:void(0)">' + smiley + '</a>')
            item.on('click', () => {
                shouts.addSmiley(smiley)
            })
            smileysContainer.append(item)
        })
        smileysContainer.append('<br />')
    },
    addSmiley: function(smiley) {
        var caret = this.inputField.focus().prop('selectionStart')
        var text1 = this.inputField.val().substring(0,caret)
        var text2 = this.inputField.val().substring(caret)
        this.inputField.val(text1 + ' ' + smiley + ' ' + text2)
        this.inputField.prop('selectionStart', caret + 4)
        this.inputField.prop('selectionEnd', caret + 4)
    },
    toggle: function() {
        $(this.options.selector).animate({
            height: "toggle"
        })
        this.enabled = !this.enabled
    },
    getInterval: function() {
        var offset = Math.floor(shouts.refreshCounts / 25)
        return (this.options.refresh + offset) * 1000
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
        var newMessages = 0
        if (response) {
            if (response.token) {
                shouts.tokenField.val(response.token)
                shouts.inputField.val('')
            }
            if (response.session) {
                shouts.session = response.session
            }
            if (response.messages) {
                shouts.refreshCounts = 0
                response.messages.forEach(message => {
                    if (!shouts.messages.includes(message.id)) {
                        var online = '<span class="author-status author-status-' + message.author.id + ' offline">&bull;</span>';
                        var row = $('<p>' +
                            '<span class="author">' + online + '<a href="' + message.author.url + '">' + message.author.name + '</a></span>' +
                            '<span class="time">' + message.time + '</span>' +
                            '<span class="text">' + message.text + '</span>' +
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
            shouts.container.find('span.author-status').removeClass('online').addClass('offline')
            if (response.online) {
                response.online.forEach(online => {
                    shouts.container.find('span.author-status-' + online).removeClass('offline').addClass('online')
                })
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
        console.log('rowClick()')
        if (message.author.id != shouts.session.id) {
            return
        }
        var data = {
            action: 'edit',
            message,
            token: shouts.tokenField.val(),
            latestId: shouts.latestId
        }
        shouts.send(data, (response) => {
            shouts.editor(response, event)
        })
    },
    editor: function(response, event) {
        response = $.parseJSON(response)
        console.log(response)
        var paragraph = $(event.currentTarget)
        paragraph.off()
        var container = paragraph.find('span.text')
        var input = $('<input type="text" />')
        var submit = $('<input type="button" value="' + shouts.options.langs.submit + '" />')
        var cancel = $('<input type="button" value="' + shouts.options.langs.cancel + '" />')
        cancel.on('click', (e) => {
            container.empty()
            container.text(response.message.text)
            var newParagraph = $('<p />')
            newParagraph.html(paragraph.html())
            paragraph.after(newParagraph)
            paragraph.remove()
            newParagraph.on('click', (event) => {
                shouts.rowClick(event, response.message)
            })
        })
        container.empty()
        container.append(input)
        container.append('&nbsp;')
        container.append(submit)
        container.append('&nbsp;')
        container.append(cancel)
        input.val(response.message.text)
        input.focus().val(input.val());
        console.log(container)
    },
    send: function(data, callback) {
        if (this.enabled) {
            if (!callback) {
                callback = this.submitted
            }
            this.submitButton.attr('disabled', true)
            $.post(this.options.url, data, callback)
        }
    }
    
}