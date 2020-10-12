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
        if (!postData.id) {
            return
        }
        var container = $('span.vote.vote-'+postData.id)
        if (!container.length) {
            container = $('<span class="vote vote-' + postData.id + '" />')
            var upvote = $('<a class="upvote">&plus;</a>')
            var downvote = $('<a class="downvote">&minus;</a>')
            var sum = $('<span class="sum" />')
            container.append(downvote)
            container.append(sum)
            container.append(upvote)
            this.update(container, postData)
            document.write($('<body />').append(container.clone()).html())
        }
        else {
            this.update(container, postData)
        }
    },
    update: function(container, postData) {
        sum = container.find('> .sum')
        if (typeof postData.sum == 'undefined') {
            container.css({display: 'none'})
            postData.sum = 0
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
            if (postData.sum > 0) {
                sum.addClass('upvoted')
            }
            if (postData.sum < 0) {
                sum.addClass('downvoted')
            }
        }
        if (postData.sum > 0) {
            container.addClass('trend-up')
        }
        if (postData.sum < 0) {
            container.addClass('trend-down')
        }
        sum.text(parseInt(postData.sum))
    },
    getTopicCounts: async function(topic) {
        if (typeof this.cache == 'object') {
            return this.cache;
        }
        this.send({topic})
    },
    send: function(data, callback) {
        if (!callback) {
            callback = (response) => {
                this.cache = response.posts
                this.posts.forEach((id) => {
                    if (typeof this.cache[id] == 'undefined') {
                        this.cache[id] = {id, sum: 0}
                    }
                    this.render(this.cache[id])
                })
            }
        }
        $.post(this.options.url, data, callback)
    }
}