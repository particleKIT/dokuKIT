<?php
/**
 * Default configuration for the dokucms template
 * 
 * @license:    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author:     Michael Klier <chi@chimeric.de>
 * @author Klaus Vormweg <klaus.vormweg@gmx.de>
 */

$conf['tpl']['dokukit']['sidebar'] = 'index';  // 'file' or 'index'
$conf['tpl']['dokukit']['cleanindex'] = 0;  // 1 or 0
$conf['tpl']['dokukit']['cleanindexlist'] = '';  // empty or comma-separated list of namespaces
$conf['tpl']['dokukit']['showsearch'] = 1;  // 1 or 0
$conf['tpl']['dokukit']['showbacklinks'] = 0;  // 1 or 0
$conf['tpl']['dokukit']['showmedia'] = 0;  // 1 or 0
$conf['tpl']['dokukit']['sidebaredit'] = 1; // 1 or 0 
$conf['tpl']['dokukit']['showextlinks'] = 1; // 1 or 0 
$conf['tpl']['dokukit']['extlinks'] = 'extlinks'; //filename 
$conf['tpl']['dokukit']['institute_de'] = $conf['title']; //german institute name
$conf['tpl']['dokukit']['institute_en'] = $conf['title'];  //english institute name
$conf['tpl']['dokukit']['shortinstitute'] = 'TTP'; //instituts short name
$conf['tpl']['dokukit']['title_prefix'] = $conf['tpl']['dokukit']['institute'].' - '; //prefix string
$conf['tpl']['dokukit']['showlogin'] = 1; //show loginbutton
$conf['tpl']['dokukit']['boxfiles'] = ''; //comma separated list of files
$conf['tpl']['dokukit']['showboxes'] = 0; //1 or 0
?>
