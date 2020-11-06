var markdown = {
    markdowns: {
        '\\\`\\\`\\\`(.+?)\\\`\\\`\\\`': '<code>$1</code>',
        '\\\*(.+?)\\\*': '<b>$1</b>',
    },
    loaded: [],
    load: function() {
        for (const key in this.markdowns) {
            this.loaded.push({
                in: new RegExp(key, 'gim'),
                out: this.markdowns[key]
            })
        }
    },
    parse: function(text) {
        return this.loaded.reduce((txt, regex) => txt.replace(regex.in, regex.out), text)
    }
}
markdown.load()