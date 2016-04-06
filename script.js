/*
 * set class 'linktocurrent' on all navigation entries that point to the current page
*/
jQuery(function(){
    baseurl = window.location.protocol + '//' + window.location.hostname;

    paths = window.location.pathname.split('/');
    path1 = paths.slice(0,2).join('/');
    path2 = paths.slice(0,3).join('/');
    patharr = [path1, path2];
    for (p in patharr) {
        if (patharr[p].substr(-1) === "/") {
            patharr.push(patharr[p]+'start');
        }
    }

    // keep only unique entries
    var patharrtmp = patharr;
    patharr = patharrtmp.sort().filter(function(item, pos, ary) {
        return !pos || item != ary[pos - 1];
    });

    for (p in patharr) {
        dest = patharr[p];
        linkstocur = jQuery('div.sidebar_box a[href="'+baseurl+dest+'"]');
        linkstocur.parents('li').addClass('linktocurrent');
    }

});
