var shouts = {
    options: {
        url: basepath + '/modules/Shouts/',
        selector: '#shouts',
        refresh: 5,
        langs: {
            submit: 'Submit',
            cancel: 'Cancel',
            delete: 'Delete',
            confirm: 'Are you sure?'
        }
    },
    context: null,
    inputField: null,
    smileysButton: null,
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
        this.context = $(this.options.selector)
        this.inputField = this.context.find('input[name=message]')
        this.inputField.on('keypress', (event) => {
            if (event.keyCode == 13) {
                this.submit(event);
            }
        })
        this.submitButton = this.context.find('input[name=submit]')
        this.submitButton.on('click', this.submit)
        this.tokenField = this.context.find('input[name=token]')
        this.container = this.context.find('div.messages')
        this.loadSmileys()
        this.refresh()
    },
    loadSmileys: function() {
        $.getJSON(basepath + '/js/ckeditor/plugins/emoji/emoji.json', (response) => {
            shouts.smileys = []
            limit = 83
            response.forEach(smiley => {
                if (smiley.group == 'people' && limit) {
                    shouts.smileys.push(smiley.symbol)
                    limit--
                }
            })
            this.smileysButton = $('<a href="javascript:void(0)">' + response[0].symbol + '</a>')
            this.smileysButton.on('click', () => {
                shouts.listSmileys()
            })
            this.inputField.after(this.smileysButton)
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
            action: 'add',
            token: shouts.tokenField.val(),
            message: {
                id: 0,
                text: shouts.inputField.val()
            },
            latestId: shouts.latestId
        }
        console.log(data)
        shouts.send(data, (response) => {
            shouts.inputField.val('')
            shouts.submitted(response)
        })
    },
    htmlentities: function(text) {
        return $('<div></div>').text(text).html()
    },
    submitted: function(response) {
        shouts.refreshCounts++
        shouts.submitButton.attr('disabled', false)
        if (typeof response == 'string') {
            response = $.parseJSON(response)
        }
        var newMessages = 0
        if (response) {
            if (response.acl && !response.acl.view) {
                shouts.context.html('')
            }
            if (response.acl && !response.acl.add) {
                shouts.inputField.after('<br />');
                shouts.inputField.remove()
                shouts.submitButton.remove()
                if (shouts.smileysButton) {
                    shouts.smileysButton.remove()
                }
            }
            if (response.token) {
                shouts.tokenField.val(response.token)
            }
            if (response.session) {
                shouts.session = response.session
            }
            if (response.messages) {
                shouts.refreshCounts = 0
                response.messages.forEach(message => {
                    message.id = parseInt(message.id)
                    message.text = shouts.htmlentities(message.text)
                    if (!shouts.messages.includes(message.id)) {
                        if(typeof shouts.options.onmessage == 'function') {
                            shouts.options.onmessage(message)
                        }
                        var row = $('<p></p>')
                        var rowAuthor = $('<span class="author"></span>')
                        var rowAuthorOnline = '<span class="author-status author-status-' + message.author.id + ' offline">&bull;</span>'
                        var rowAuthorName = $('<a href="' + message.author.url + '"></a>')
                        rowAuthorName.text(message.author.name)
                        rowAuthor.append(rowAuthorOnline)
                        rowAuthor.append(rowAuthorName)
                        var rowTime = $('<span class="time"></span>')
                        rowTime.text(message.time)
                        var rowText = $('<span class="text"></span>')
                        rowText.html(message.text)
                        row.append(rowAuthor)
                        row.append(rowTime)
                        row.append(rowText)
                        var acl = message['acl']
                        if (acl['edit'] || acl['delete']) {
                            row.on('click', (event) => {
                                shouts.rowClick(event, message)
                            })
                        }
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
            action: 'message',
            message,
            token: shouts.tokenField.val(),
            latestId: shouts.latestId
        }
        shouts.send(data, (response) => {
            shouts.editor(response, event)
        })
    },
    editor: function(response, event) {
        if (typeof response == 'string') {
            response = $.parseJSON(response)
        }
        console.log(response)
        var paragraph = $(event.currentTarget)
        paragraph.off()
        var container = paragraph.find('span.text')
        var input = $('<input type="text" />')
        var submit = $('<input type="button" value="' + shouts.options.langs.submit + '" />')
        var cancel = $('<input type="button" value="' + shouts.options.langs.cancel + '" />')
        var del = $('<input type="button" value="' + shouts.options.langs.delete + '" />')
        var acl = response.message['acl']
        cancel.on('click', (e) => {
            response.message.text = shouts.htmlentities(response.message.text)
            if(typeof shouts.options.onmessage == 'function') {
                shouts.options.onmessage(response.message)
            }
            container.empty()
            container.html(response.message.text)
            var newParagraph = $('<p />')
            newParagraph.html(paragraph.html())
            paragraph.after(newParagraph)
            paragraph.remove()
            newParagraph.on('click', (event) => {
                shouts.rowClick(event, response.message)
            })
        })
        del.on('click', (e) => {
            if (!confirm(shouts.options.langs.confirm)) {
                return
            }
            var data = {
                action: 'delete',
                message: {
                    id: parseInt(response.message.id),
                },
                token: response.token,
                latestId: shouts.latestId
            }
            shouts.send(data, (response) => {
                if (typeof response == 'string') {
                    response = $.parseJSON(response)
                }
                if (!response.error) {
                    paragraph.remove()
                }
                shouts.submitted(response)
            })
        })
        submit.on('click', (e) => {
            var data = {
                action: 'edit',
                message: {
                    id: parseInt(response.message.id),
                    text: input.val()
                },
                token: response.token,
                latestId: shouts.latestId
            }
            shouts.send(data, (response) => {
                if (typeof response == 'string') {
                    response = $.parseJSON(response)
                }
                if (!response.error) {
                    response.message.text = shouts.htmlentities(response.message.text)
                    if(typeof shouts.options.onmessage == 'function') {
                        shouts.options.onmessage(response.message)
                    }
                    container.empty()
                    container.html(response.message.text)
                    var newParagraph = $('<p />')
                    newParagraph.html(paragraph.html())
                    paragraph.after(newParagraph)
                    paragraph.remove()
                    newParagraph.on('click', (event) => {
                        shouts.rowClick(event, response.message)
                    })
                }
                shouts.submitted(response)
            })
        })
        container.empty()
        container.append(input)
        if (acl['edit']) {
            container.append('&nbsp;')
            container.append(submit)
        }
        container.append('&nbsp;')
        container.append(cancel)
        if (acl['delete']) {
            container.append('&nbsp;')
            container.append(del)
        }
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