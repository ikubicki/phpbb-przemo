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
        if (!options.post) {
            return;
        }
        this.posts.push(options.post)
        this.render({id: options.post})
    },
    render: function(postData) {
        console.log('render')
        if (!postData.id) return
        console.log(postData)
        var container = $('span.vote.vote-'+postData.id)
        if (!container.length) {
            console.log('written')
            container = $('<span class="vote vote-' + postData.id + '" />')
            var upvote = $('<a class="upvote">&plus;</a>')
            var downvote = $('<a class="downvote">&minus;</a>')
            var count = $('<span class="count" />')
            container.append(downvote)
            container.append(count)
            container.append(upvote)
            this.update(container, postData)
            document.write($('<body />').append(container.clone()).html())
        }
        else {
            this.update(container, postData)
        }
    },
    update: function(container, postData) {
        count = container.find('> .count')
        if (typeof postData.count == 'undefined') {
            container.css({display: 'none'})
            postData.count = 0
        }
        else {
            container.removeAttr('style')
        }
        if (postData.voted > 0) {
            container.addClass('upvoted')
        }
        else if (postData.voted < 0) {
            container.addClass('downvoted')
        }
        else {
            if (postData.count > 0) {
                count.addClass('upvoted')
            }
            if (postData.count < 0) {
                count.addClass('downvoted')
            }
        }
        if (postData.count > 0) {
            container.addClass('trend-up')
        }
        if (postData.count < 0) {
            container.addClass('trend-down')
        }
        count.text(parseInt(postData.count))
        console.log(container)
    },
    getTopicCounts: async function(topic) {
        if (typeof this.cache == 'object') {
            return this.cache;
        }
        this.send({topic})
    },
    getPostCounts: function(post) {
        $.when(this.getTopicCounts(this.topic)).done((r) => {
            console.log(r)
        })
        
        return data[post]
    },
    send: function(data, callback) {
        if (!callback) {
            callback = (response) => {
                this.cache = response.posts
                this.posts.forEach((id) => {
                    this.render(this.cache[id])
                })
            }
        }
        $.post(this.options.url, data, callback)
    }
}