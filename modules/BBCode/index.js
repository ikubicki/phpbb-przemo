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
    },
    youtube: function(el, video) {
        var iframe = '<iframe data-lightbox="topic-set" src="https://www.youtube.com/embed/'+video+'" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="video"></iframe>'
        $(el).after(iframe)
        $(el).remove()
    }
}
bbcode.load([
    {
        in: '\\[b\\](.+?)\\[/b\\]',
        out: '<b class="bbcode">$1</b>',
    },
    {
        in: '\\[u\\](.+?)\\[/u\\]',
        out: '<u class="bbcode">$1</u>',
    },
    {
        in: '\\[i\\](.+?)\\[/i\\]',
        out: '<i class="bbcode">$1</i>',
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
        in: '\\[colou?r=\\"?([^\\]]+)\\"?\\](.+?)\\[/colou?r\\]',
        out: '<span style="color:$1" class="bbcode">$2</span>',
    },
    {
        in: '\\[(youtube|yt)\\](.+?)((v|embed)(=|/)([a-zA-Z0-9_]+))(.+?)\\[/(youtube|yt)\\]',
        out: '<a href="javascript:void(0)" onclick="bbcode.youtube(this, \'$6\')"  class="youtube"><img src="https://img.youtube.com/vi/$6/0.jpg" /></a>'
//        out: '<iframe src="https://www.youtube.com/embed/$5" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="video"></iframe>',
    },
    {
        in: '\\[/?[a-z0-9_]+\\]',
        out: '',
    },
    {
        in: '\\[/?[a-z0-9_]+=([^\\]]+)\\]',
        out: '',
    }
])