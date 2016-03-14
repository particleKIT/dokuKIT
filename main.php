<?php
/**
 * DokuWiki DokuKIT Template, based on DokuCMS
 *
 * @link  https://github.com/particleKIT/dokuKIT
 * @author Martin Gabelmann <martin@gabelmann.biz> 
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
', $conf["tpl"]["dokukit"]["title_prefix"];
echo preg_replace('/^en:/','',tpl_pagetitle(null, true));
echo '
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
    <div class="dokuwiki">
        <div id="wrapper">
';
html_msgarea();
echo '
        <div id="metanavigation">';
tpl_link(wl(),'HOME','name="dokuwiki__top" id="dokuwiki__top"');
tpl_link('https://www.kit.edu/impressum.php', tpl_getLang('imprint'));
// tpl_link(DOKU_URL.'imprint', tpl_getLang('imprint'));
// tpl_link(DOKU_URL.'sitemap', 'SITEMAP');
tpl_link('https://www.kit.edu/', 'KIT');

$translation = plugin_load('helper','translation');
if ($translation) { 
    echo $translation->showTranslations();
    $conf['title'] =  $conf["tpl"]["dokukit"]["institute"][$conf['lang']];
}


tpl_button('admin');
if($_SERVER['REMOTE_USER']) tpl_button('profile');

if($ACT != 'login' && $ACT != 'logout' && $_SERVER['REMOTE_USER'] || $conf["tpl"]["dokukit"]["showlogin"]) tpl_button('login');
echo '
        </div>



    <div id="head">
        <div id="logo">
            <a href="https://www.kit.edu" title="'.$lang['kitlogo'].'">
                <img src="'.DOKU_URL.'/lib/tpl/dokukit/images/logo_'.$conf['lang'].'_163.jpg" alt="'.$lang['kitlogo'].'">
            </a>
        </div>
        <div id="head-image" >
            <div id="head-text" class="big_font">';
            tpl_link(wl(),$conf['title'].' ('. $conf["tpl"]["dokukit"]["shortinstitute"].')' ,'name="dokuwiki__top" id="dokuwiki__top" accesskey="h" title="[ALT+H]"');

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

    <div id="right-row"></div>';


if($_SERVER['REMOTE_USER']){
echo '
     <div class="site_tools">';
  tpl_button('subscribe');
  tpl_button('history');
  tpl_button('revert');

  if($ACT != 'login' && $ACT != 'logout'){
    tpl_button('media');
    tpl_button('edit');
  }
echo '
      </div>';
}

echo '    <div id="middle-row">
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
                                <a href="#top" class="footer-right"><img src="'.DOKU_URL.'/lib/tpl/dokukit/images/totop.png" style="margin-top:6px" title="Nach oben" /></a>
                            </div>
                        </div>
                    </div>


                    <div id="owner">
                        <span id="owner-text" style="float:right; margin-right:31px">';
if($ACT != 'diff' && $ACT != 'edit' && $ACT != 'preview' && $ACT != 'admin' && $ACT != 'login' && $ACT != 'logout' && $ACT != 'profile' && $ACT != 'revisions') {
  _tpl_pageinfo();
}
echo '                   </span>
                         <span id="owner-text">'.$lang['kitfooter'].'</span>
                    </div>
';


/* provide DokuWiki housekeeping, required in all templates */ 
if($_SERVER['REMOTE_USER']){
  tpl_indexerWebBug();
}
echo '</div>
    </div>
 </div>
</body>
</html>
';
?>
