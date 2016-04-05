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
        if (patharr[p].endsWith('/')) {
            patharr.push(patharr[p]+'start');
        }
    }

    // keep only unique entries
    patharr = Array.from(new Set(patharr)); 


    for (p in patharr) {
        dest = patharr[p];
        linkstocur = jQuery('div.sidebar_box a[href="'+baseurl+dest+'"]');
        linkstocur.parents('li').addClass('linktocurrent');
    }

});
