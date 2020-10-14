var votes = {
    options: {
        url: '/modules/votes/votes.php'
    },
    cache: false,
    topic: null,
    posts: [],
    load: function(options) {
        if (options.topic) {
            this.topic = options.topic
            this.send({topic: this.topic})
        }
    },
    show: function(options) {
        if (!options.post || !options.selector) {
            return;
        }
        this.posts.push(options.post)
        this.render(options.selector, {id: options.post})
    },
    render: function(selector, postData) {
        if (!postData.id) {
            return
        }
        var container = $('span.vote.vote-'+postData.id)
        if (!container.length) {
            container = $('<span class="vote vote-' + postData.id + '" />')
            var upvote = $('<a class="upvote">&plus;</a>')
            var downvote = $('<a class="downvote">&minus;</a>')
            var sum = $('<span class="sum" />')
            upvote.on('click', (e) => this.upvote(postData))
            downvote.on('click', (e) => this.downvote(container, postData))
            container.append(downvote)
            container.append(sum)
            container.append(upvote)
            container.css({display: 'none'})
            this.update(postData)
            $(selector).append(container)
        }
        else {
            this.update(postData)
        }
    },
    upvote: function(postData) {
        this.send({
            topic: this.topic,
            up: postData.id,
        })
    },
    downvote: function(container, postData) {
        this.send({
            topic: this.topic,
            down: postData.id,
        })
    },
    update: function(postData) {
        container = $('span.vote.vote-'+postData.id)
        if (container.length < 1) {
            return
        }
        sum = container.find('.sum')
        if (typeof postData.sum == 'undefined') {
            container.css({display: 'none'})
            postData.sum = 0
        }
        else {
            container.removeAttr('style')
        }
        if (postData.voted > 0) {
            container.addClass('upvoted')
            container.removeClass('downvoted')
        }
        else if (postData.voted < 0) {
            container.removeClass('upvoted')
            container.addClass('downvoted')
        }
        else {
            if (postData.sum > 0) {
                sum.addClass('upvoted')
                sum.removeClass('downvoted')
            }
            if (postData.sum < 0) {
                sum.removeClass('upvoted')
                sum.addClass('downvoted')
            }
        }
        if (postData.sum > 0) {
            container.addClass('trend-up')
            container.removeClass('trend-down')
        }
        if (postData.sum < 0) {
            container.removeClass('trend-up')
            container.addClass('trend-down')
        }
        sum.text(parseInt(postData.sum))
    },
    send: function(data, callback) {
        if (!callback) {
            callback = (response) => {
                this.cache = response.posts
                this.posts.forEach((id) => {
                    if (typeof this.cache[id] == 'undefined') {
                        this.cache[id] = {id, sum: 0}
                    }
                    this.update(this.cache[id])
                })
            }
        }
        $.post(this.options.url, data, callback)
    }
}