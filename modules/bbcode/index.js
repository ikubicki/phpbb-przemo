var bbcode = {
    bbcodes: {
        '\\[b\\](.+?)\\[/b\\]': '<b class="bbcode">$1</b>',
        '\\[img\\](.+?)\\[/img\\]': '<a href="$1" rel="nofollow" data-lightbox="topic-set" target="_blank"><img src="$1" /></a>'
    },
    loaded: [],
    load: function() {
        for (const key in this.bbcodes) {
            this.loaded.push({
                in: new RegExp(key, 'gim'),
                out: this.bbcodes[key]
            })
        }
    },
    parse: function(text) {
        console.log(text)
        return this.loaded.reduce((txt, regex) => txt.replace(regex.in, regex.out), text)
    }
}
bbcode.load()