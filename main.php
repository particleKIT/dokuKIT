<?php
/**
 * DokuWiki DokuCMS Template
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:templates
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author Klaus Vormweg <klaus.vormweg@gmx.de>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

// include custom template functions stolen from arctic template
require_once(dirname(__FILE__).'/tpl_functions.php');

echo '
<!DOCTYPE html>
<html lang="', $conf['lang'], '" dir="', $lang['direction'], '">
<head>
  <meta charset="utf-8" />
  <title>
';
tpl_pagetitle();
echo '[', strip_tags($conf['title']), ']
  </title>
';
tpl_metaheaders();
echo tpl_favicon(array('favicon', 'mobile'));
echo '
<!--[if lt IE 7]>
   <style type="text/css">
      div.page { width: 55em !important; }
   </style>
<![endif]-->
</head>

<body>
    <div id="wrapper">
';
html_msgarea();


echo '
        <div id="metanavigation"><a accesskey="1" href="/index.php">Home</a>&nbsp;|&nbsp;<a accesskey="8" href="/impressum.php">Impressum</a>&nbsp;|&nbsp;<a accesskey="3" href="/sitemap.php">Sitemap</a>&nbsp;|&nbsp;<a href="http://www.kit.edu">KIT</a> | ';



if($ACT != 'login' && $ACT != 'logout') tpl_button('login');
tpl_button('admin');
if($_SERVER['REMOTE_USER']) tpl_button('profile');

$translation = plugin_load('helper','translation');
if ($translation) echo $translation->showTranslations();


echo '
        </div>



    <div id="head">
        <div id="logo">
            <a href="http://www.kit.edu" title="KIT-Logo - Link zur KIT-Startseite">
                <img src="lib/tpl/dokukit/images/kit_logo_V2_de.png" alt="KIT-Logo - Link zur KIT-Startseite">
            </a>
        </div>
        <div id="head-image" >
            <div id="head-text" class="big_font">';
            tpl_link(wl(),$conf['title'],'name="dokuwiki__top" id="dokuwiki__top" accesskey="h" title="[ALT+H]"');

echo '      </div>
            <div id="head-text-corner">&nbsp;</div>               
        </div>
    </div>


    <div class="spacer"></div>
';

#if($conf['breadcrumbs']){
#  echo '    <div class="breadcrumbs">
#';
#  tpl_breadcrumbs();
#  echo '  </div>
#';
#}

#if($conf['youarehere']){
#  echo '    <div class="breadcrumbs">
#';
#  tpl_youarehere();
#  echo '    </div>
#';
#}
#echo '
#  </header>
#';
tpl_flush();

if($ACT != 'diff' && $ACT != 'edit' && $ACT != 'preview' && $ACT != 'admin' && $ACT != 'login' && $ACT != 'logout' && $ACT != 'profile' && $ACT != 'revisions' && $ACT != 'media') {
    echo '
         <div id="container">
            <div id="left-row">
                <div id="menu-box">';

if($conf['tpl']['dokukit']['showsearch']) {  
        echo '
                    <div id="suchen">';
        tpl_searchform();
        echo '
                    </div>';
    }

    _tpl_sidebar(); 
    echo '   
            </div>
        <br/>
    </div>

    <div id="right-row"></div>
    <div id="middle-row">
        <div id="content">';
  tpl_content(); 
} else {
    echo '
    <div id="container" style="background-color: #fff;">
        <div id="middle-row" style="margin-left:0; width: 960px;float:none;">
            <div id="content">';
  tpl_content();
}

echo '
        </div>
    </div>
';

tpl_flush();
echo '
<div class="clear"><!-- --></div>

<div id="footer-container">
                    <div class="spacer"><!-- --></div>
                    <div id="footer">
                        <div id="footer-corner"><!-- --></div>
                        <div id="footer-text">
                            <div id="footer-content">
                                <a href="#top" class="footer-right"><img src="lib/tpl/dokukit/images/totop.png" style="margin-top:6px" title="Nach oben" /></a>
                            </div>
                        </div>
                    </div>


                    <div id="owner">
                        <span id="owner-text" style="float:right; margin-right:31px">';
if($ACT != 'diff' && $ACT != 'edit' && $ACT != 'preview' && $ACT != 'admin' && $ACT != 'login' && $ACT != 'logout' && $ACT != 'profile' && $ACT != 'revisions') {
  _tpl_pageinfo();
}
echo '                   </span>
                         <span id="owner-text">KIT – Universität des Landes Baden-Württemberg und nationales Forschungszentrum in der Helmholtz-Gemeinschaft</span>
                    </div>
';

if($_SERVER['REMOTE_USER']){
  tpl_button('subscribe');
  tpl_button('history');
  tpl_button('revert');
}

if($conf['tpl']['dokukit']['showbacklinks']) tpl_button('backlink');

if(!$_SERVER['REMOTE_USER'] && $ACT != 'login' && $ACT != 'logout'){ 
  if($conf['tpl']['dokukit']['showmedia']) {   
    tpl_button('media');
  }
} else {
  if($ACT != 'login' && $ACT != 'logout'){
    tpl_button('media');
    tpl_button('edit');
  }
}
#tpl_license(false);
/* provide DokuWiki housekeeping, required in all templates */ 
tpl_indexerWebBug();
echo '</div>
    </div>
</body>
</html>
';
?>
