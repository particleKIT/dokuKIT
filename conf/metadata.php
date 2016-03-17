<?php
/**
 * configuration-manager metadata for the dokucms template
 * 
 * @license:    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author:     Michael Klier <chi@chimeric.de>
 * @author Klaus Vormweg <klaus.vormweg@gmx.de>
 */

$meta['sidebar'] = array('multichoice', '_choices' => array('file', 'index'));
$meta['cleanindex'] = array('onoff');
$meta['cleanindexlist'] = array('string');
$meta['showsearch'] = array('onoff');
$meta['showbacklinks'] = array('onoff');
$meta['showmedia'] = array('onoff');
$meta['sidebaredit'] = array('onoff');
$meta['showextlinks'] = array('onoff'); 
$meta['extlinks'] = array('string'); 
$meta['title_prefix'] = array('string'); 
$meta['institute_de'] = array('string'); 
$meta['institute_en'] = array('string'); 
$meta['shortinstitute'] = array('string'); 
$meta['showlogin'] = array('onoff'); 
$meta['boxfiles'] = array('string');
$meta['showboxes'] = array('onoff');
?>
