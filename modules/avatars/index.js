var avatars = {
    show: function(options) {
        var url = '/modules/Avatars/index.php?user=' + parseInt(options.user)
        document.write('<img class="avatar '+options.class+'" style="'+options.style+'" src="'+url+'" />');
    }
}