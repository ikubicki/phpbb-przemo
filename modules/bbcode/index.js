var url_expression = '(https?:\\/\\/(www\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b([-a-zA-Z0-9()@:%_\\+.~#?&//=]*))'
var bbcode = {
    options: {
        langs: {
            missing_image: 'Image is missing',
        }
    },
    loaded: [],
    load: function(bbcodes) {
        bbcodes.forEach((bbcode) => {
            this.loaded.push({
                in: new RegExp(bbcode.in, 'gim'),
                out: bbcode.out
            })
        })
    },
    parse: function(text) {
        text = text.split('&amp;').join('&')
        return this.loaded.reduce((txt, regex) => txt.replace(regex.in, regex.out), text)
    }
}
bbcode.load([
    {
        in: '\\[b\\](.+?)\\[/b\\]',
        out: '<b class="bbcode">$1</b>',
    },
    {
        in: '\\[img\\]'+url_expression+'\\[/img\\]',
        out: '<a href="$1" rel="nofollow" data-lightbox="topic-set" target="_blank"><img src="$1" onerror="this.parentElement.replaceWith(\''+bbcode.options.langs.missing_image+'\')" /></a>',
    },
    {
        in: '\\[url=\\"?'+url_expression+'\\"?\\](.+?)\\[/url\\]',
        out: '<a rel="nofollow" href="$1" class="bbcode">$4</a>',
    },
    {
        in: '\\[url\\]'+url_expression+'\\[/url\\]',
        out: '<a rel="nofollow" href="$1" class="bbcode">$1</a>',
    },
    {
        in: '\\[/?[a-z0-9_]+\\]',
        out: '',
    }
])