<?php
/**
 * DokuWiki Template DokuKIT Functions - adapted from DokuCMS template
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author  Michael Klier <chi@chimeric.de>
 * @author Klaus Vormweg <klaus.vormweg@gmx.de>
 * @author Robin Roth <robin.roth@kit.edu>
 * @author Martin Gabelmann <martin@gabelmann.biz>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

/**
 * Prints the sidebars
 *
 */
function _tpl_sidebar() {
    global $lang;
    global $conf;
    global $ID;
    if(!defined('DOKU_LF')) define('DOKU_LF',"\n");
    $pname = 'sidebar';
    $tpl = $conf['template'];

    // print static sidebar from wiki page(s)
    if($conf['tpl'][$tpl]['sidebar']== 'file')  {
        // search for sidebar files recursively starting in the current namespace
        $ns_sb = _getNsSb($ID);
        // print sidebar of the current namespace
        if($ns_sb && auth_quickaclcheck($ns_sb) >= AUTH_READ) {
            echo '<div class="sidebar_box file">', DOKU_LF;
            echo p_sidebar_xhtml($ns_sb), DOKU_LF;
            echo '</div>', DOKU_LF;
         // print sidebar from top root namespace 
         } elseif(@file_exists(wikiFN($pname)) && auth_quickaclcheck($pname) >= AUTH_READ) {
            echo '<div class="sidebar_box file">', DOKU_LF;
            echo p_sidebar_xhtml($pname), DOKU_LF;
            echo '</div>', DOKU_LF;
        } else {
            echo '<div class="sidebar_box">', DOKU_LF;
            echo '&nbsp;', DOKU_LF;
            echo '</div>', DOKU_LF;
        }
    // load sidebar from index
	} else {
        echo '<div class="sidebar_box dynamic">', DOKU_LF;
        echo '  ', p_index_xhtml($ID), DOKU_LF;
        echo '</div>', DOKU_LF;
	 }

    // load wiki sidebar file containing external links/additional content 
    if(
        $conf['tpl'][$tpl]['showextlinks']== '1' && 
        @file_exists(wikiFN($conf['tpl'][$tpl]['extlinks'])) && 
        auth_quickaclcheck($conf['tpl'][$tpl]['extlinks']) >= AUTH_READ 
      )  
    {
        echo '<div class="sidebar_box external_sidebar">', DOKU_LF;
        echo p_sidebar_xhtml($conf['tpl'][$tpl]['extlinks']), DOKU_LF;
        echo '</div>', DOKU_LF;
    }	

}

/**
 * right info boxes
 */
function _tpl_infobox() {
    global $lang;
    global $conf;
    global $ID;
    
    if(!defined('DOKU_LF')) define('DOKU_LF',"\n");
    $boxfiles = explode(',', $conf['tpl']['dokukit']['boxfiles']);
    $infoboxes = array();
    
    if($ID !=  $conf['start'] && $ID != $conf['lang'].':'.$conf['start'] || !$conf['tpl']['dokukit']['showboxes']) unset($boxfiles);
    
    if(count($boxfiles)>0){
        while (list(, $pname) = each($boxfiles)) {
            $ns_sb = _getNsSb($ID, $pname);
            if($ns_sb && auth_quickaclcheck($ns_sb) >= AUTH_READ) {
                $infoboxes[] = '<div class="infobox"><div class="infobox-inner">'.p_sidebar_xhtml($ns_sb).'</div></div>';
            } elseif(@file_exists(wikiFN($pname)) && auth_quickaclcheck($pname) >= AUTH_READ) {
                $infoboxes[] = '<div class="infobox"><div class="infobox-inner">'.p_sidebar_xhtml($pname).'</div></div>';
            }
        }
    }
    
    if(count($infoboxes)>0){
        echo '<div id="right-row">', DOKU_LF;
        while (list(, $infobox) = each($infoboxes)) echo $infobox, DOKU_LF;
        echo '</div>', DOKU_LF;
    } else {
        echo '<style type="text/css">#middle-row, .tabelle3, .ptabelle, .ptabelleblank, .datentabelle { width:760px !important; }  </style>', DOKU_LF;
    }
}


/**
 * searches for namespace sidebars
 */
function _getNsSb($id, $pname = 'sidebar') {
    $ns_sb = '';
    $path  = explode(':', $id);
    
    while(count($path) > 0) {
        $ns_sb = implode(':', $path).':'.$pname;
        if(@file_exists(wikiFN($ns_sb))) return $ns_sb;
        array_pop($path);
    }
    
    // nothing found
    return false;
}

/**
 * Removes the TOC of the sidebar pages and 
 * shows a edit button if the user has enough rights
 *
 */
function p_sidebar_xhtml($sb) {
    global $conf;
    $tpl = $conf['template'];
    $data = p_wiki_xhtml($sb,'',false);
    
    if(auth_quickaclcheck($sb) >= AUTH_EDIT and $conf['tpl'][$tpl]['sidebaredit']) {
        $data .= '<div class="secedit">'.html_btn('secedit',$sb,'',array('do'=>'edit','rev'=>'','post')).'</div>';
    }
    // strip TOC
    $data = preg_replace('/<div class="toc">.*?(<\/div>\n<\/div>)/s', '', $data);
    // replace headline ids for XHTML compliance
    $data = preg_replace('/(<h.*?><a.*?id=")(.*?)(">.*?<\/a><\/h.*?>)/','\1sb_left_\2\3', $data);
    return ($data);
}

/**
 * Renders the Index
 *
 */
function p_index_xhtml($ns) {
    require_once(DOKU_INC.'inc/search.php');
    global $conf;
    global $ID;
    $dir = $conf['datadir'];
    $tpl = $conf['template'];
    if(isset($conf['start'])) {
        $start = $conf['start'];
    } else {
        $start = 'start';
    }
    
    $ns  = cleanID($ns);
    # fixme use appropriate function
    if(empty($ns)){
        $ns = dirname(str_replace(':','/',$ID));
        if($ns == '.') $ns ='';
    }
    $ns  = utf8_encodeFN(str_replace(':','/',$ns));
    
    $data = array();
    search($data,$conf['datadir'],'search_index',array('ns' => $ns));
    $i = 0;
    $cleanindexlist = array();
    if($conf['tpl'][$tpl]['cleanindexlist']) {
        $cleanindexlist = explode(',', $conf['tpl'][$tpl]['cleanindexlist']);
     	$i = 0;
     	foreach($cleanindexlist as $tmpitem) {
     	    $cleanindexlist[$i] = trim($tmpitem);
     		$i++;
     	}
    }
    $i = 0;
    foreach($data as $item) {
    if($conf['tpl'][$tpl]['cleanindex']) {
        if($item['id'] == 'playground' or $item['id'] == 'wiki') {
            unset($data[$i]);
        }
        if(count($cleanindexlist)) {
            if(strpos($item['id'], ':')) {
                list($tmpitem) = explode(':',$item['id']);
            } else {
            	$tmpitem = $item['id'];
            }
            if(in_array($tmpitem, $cleanindexlist)) {
              unset($data[$i]);
            }
        }
    }
    if(
        $item['id'] == 'sidebar' or 
        $item['id'] == $start or
        preg_match('/:'.$start.'$/',$item['id']) or 
        !empty($conf['hidepages']) and preg_match('/'.$conf['hidepages'].'$/',$item['id']) or
        $item['id'] == $conf['tpl']['dokukit']['extlinks']
    ) {
        unset($data[$i]);
      }
      $i++;
      
    }  
    # echo index with empty items removed  
    echo html_buildlist($data,'idx','_html_list_index','html_li_index');
}

/**
 * Index item formatter
 *
 * User function for html_buildlist()
 *
 */
function _html_list_index($item){
    global $ID;
    global $conf;
    $ret = '';

    if($item['type']=='d'){
        if(@file_exists(wikiFN($item['id'].':'.$conf['start']))) {
            $ret .= html_wikilink($item['id'].':'.$conf['start']);
        } else {
            $ret .= html_wikilink($item['id'].':');
        }
    } else {
        $ret .= html_wikilink(':'.$item['id']);
    }
    return $ret;
}

# dokucms modified version of pageinfo 
function _tpl_pageinfo(){
    global $conf;
    global $lang;
    global $INFO;
    global $ID;
    
    // return if we are not allowed to view the page
    if (!auth_quickaclcheck($ID)) { return; }
    
    // prepare date and path
    $date = dformat($INFO['lastmod']);
    
    // echo it
    if($INFO['exists']){
        echo $lang['lastmod'], ': ', $date;
        if($_SERVER['REMOTE_USER']) {
            if($INFO['editor']) {
                echo ' ', $lang['by'], ' ', $INFO['editor'];
            } else {
                echo ' (', $lang['external_edit'], ')';
            }
            if($INFO['locked']){
                echo ' &middot; ', $lang['lockedby'], ': ', $INFO['locked'];
            }
        }
        return true;
    }
    return false;
}

?>
