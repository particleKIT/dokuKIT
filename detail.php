<?php
/**
 * DokuWiki Dokucms Template
 *
 * This is the template for displaying image details
 *
 * @link   http://dokuwiki.org/templates
 * @link   http://wiki.splitbrain.org/wiki:tpl:templates
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author Klaus Vormweg <klaus.vormweg@gmx.de>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
echo '<!DOCTYPE html>
<html lang="', $conf['lang'], '" dir="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>', hsc(tpl_img_getTag('IPTC.Headline',$IMG)), ' [', strip_tags($conf['title']),']
  </title>
';
tpl_metaheaders();
echo '
  <link rel="shortcut icon" href="', DOKU_TPL, 'images/favicon.ico" />
</head>
<body>
<div class="dokuwiki">
';
html_msgarea();
echo '
  <div class="page" style="margin-left: 1em;">
';
if($ERROR) { 
  print $ERROR; 
} else {
  echo '
    <h1>', hsc(tpl_img_getTag('IPTC.Headline',$IMG)), '</h1>
    <div class="img_big">
';
  tpl_img(900,500);
  echo '    <p class="img_caption">';
  print nl2br(hsc(tpl_img_getTag('simple.title')));
  echo '</p>
';
  echo '    </div>
    <div class="img_detail">
      <dl class="img_tags">
';
  $config_files = getConfigFiles('mediameta');
  foreach ($config_files as $config_file) {
      if(@file_exists($config_file)) include($config_file);
  }

  foreach($fields as $key => $tag){
      $t = array();
      if (!empty($tag[0])) $t = array($tag[0]);
      if(is_array($tag[3])) $t = array_merge($t,$tag[3]);
      $value = tpl_img_getTag($t);
      if ($value) {
          echo '<dt>'.$lang[$tag[1]].':</dt><dd>';
          if ($tag[2] == 'date') echo dformat($value);
          else echo hsc($value);
          echo '</dd>';
      }
  }
  echo '
      </dl>
    </div>
';
  echo '      <p class="img_footer">&larr; ', $lang['img_backto'], ' '; 
  tpl_pagelink($ID); 
  echo '</p>
';
  $imgNS = getNS($IMG);
  $authNS = auth_quickaclcheck("$imgNS:*");
  if ($authNS >= AUTH_UPLOAD) {
      echo '<p class="img_back"><a href="'.media_managerURL(array('ns' => $imgNS, 'image' => $IMG)).'">'.$lang['img_manager'].'</a></p>';
  }
}
echo '  </div>
</div>
</body>
</html>
';
?>
