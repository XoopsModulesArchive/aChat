<?php
// $Id: functions.php, see below 
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

// Créé par Niluge_Kiwi
// v 0.2 2006/08/23 16:17:37
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

function aChat_adminmenu($header = '', $currentoption){
	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:12px; line-height:normal; border-top: 1px solid #b7ae88; border-left: 1px solid #b7ae88; border-right: 1px solid #b7ae88; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/aChat/images/bg.gif') repeat-x left bottom; font-size:12px; line-height:normal; border-left: 1px solid #b7ae88; border-right: 1px solid #b7ae88; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/aChat/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #b7ae88; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/aChat/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";

	global $xoopsModule, $xoopsConfig;

	$myts = &MyTextSanitizer::getInstance();

	$tblColors = Array_Fill(0,8,'');
	$tblColors[$currentoption] = 'current';

	include 'menu.php';


	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	echo '<td style="font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px; valign: top;">';
	for( $i=0; $i<count($headermenu); $i++ ){
		echo '<a class="nobutton" href="' . $headermenu[$i]['link'] .'">' . $headermenu[$i]['title'] . '</a> ';
		if ($i < count($headermenu)-1) {
			echo "| ";
		}
	}
	echo "<td style=\"font-size: 12px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $xoopsModule->name() . " " . _AM_ACHAT_MODULEADMIN . "</b> " . $header . "</td>";

	echo "</tr></table>";
	echo "</div>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	for( $i=0; $i<count($adminmenu); $i++ ){
		echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/'.$xoopsModule->dirname().'/' . $adminmenu[$i]['link'] . '"><span>' . $adminmenu[$i]['title'] . '</span></a></li>';
	}
	echo "</ul></div>";
    echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
}

function aChat_adminfooter() {
	echo '<p/>';
	OpenTable();
	echo '<div style="text-align: center; vertical-align: center">';
        echo _AM_ACHAT_CREDIT;
        echo '</div>';
	CloseTable();
	echo '</div>';
}

function aChat_exportTXT ($n) {
	// fonction qui renvoie un fichier txt contenant les $n 1ers messages
	
	global $xoopsDB, $xoopsUser, $xoopsModuleConfig, $myts;
	include_once XOOPS_ROOT_PATH . '/class/template.php';
	
	// Configuration de l'affichage des messages
	$html = 0;
	$smiley = $xoopsModuleConfig['use_smilies'];
	$bbcodes = $xoopsModuleConfig['use_bbcodes'];
	
	// Gestion du template
	$xoopsTpl = new XoopsTpl();
	$xoopsTpl->assign('title', _MD_ACHAT_TITLE);

	// Gestion du contenu depuis la base de donnée
	$result = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( "achat_messages" ) . " ORDER BY `mid` ASC", $n);
	
	while ($myrow = $xoopsDB->fetchArray($result)) {
		$myrow['uname'] = XoopsUser::getUnameFromId($myrow['uid']);
		$myrow['msg'] =  $myts->makeTareaData4Show($myrow['msg'],$html,$smiley,$bbcodes);
		$myrow['date'] = formatTimestamp($myrow['date']);
		$sortie[] = $myrow;
	}
	$xoopsTpl->assign('messages', $sortie);
	$texte = $xoopsTpl->fetch('db:achat_viewlogs.html');

	return $texte;
}


function create_file($name, $content) {

	if($fh =  @fopen($name,'w') ) {
	    fwrite($fh, $content);
	    fclose($fh);
		return true;
	}
	return false;
}

function purge_msg($n) {

	global $xoopsDB;
	
	$sql = "DELETE FROM " . $xoopsDB -> prefix( "achat_messages" ) . " ORDER BY `mid` ASC LIMIT " . intval($n) . "";
	return $xoopsDB->queryF($sql);
}

function delete_msg($mid) {

	global $xoopsDB;
	
	$sql = "DELETE FROM " . $xoopsDB -> prefix( "achat_messages" ) . " WHERE `mid` = " . intval($mid) . "";
	return $xoopsDB->queryF($sql);
}

function get_nbre_msg() {

	global $xoopsDB;
	
	$result = $xoopsDB->query( "SELECT COUNT(*) FROM " . $xoopsDB->prefix( "achat_messages" ) . "" );
	list( $count ) = $xoopsDB->fetchRow( $result );
	
	return $count;
}

/** From wf downloads
 * save_Permissions()
 * 
 * @param $groups
 * @param $id
 * @param $perm_name
 * @return 
 **/
function aChat_save_Permissions($groups, $perm_name)
{
    $result = true;
    $hModule = & xoops_gethandler('module');
    $Module = & $hModule -> getByDirname('aChat');

    $module_id = $Module -> getVar('mid');
    $gperm_handler = & xoops_gethandler('groupperm'); 

    /* 
	* First, if the permissions are already there, delete them
	*/ 
    $gperm_handler -> deleteByModule($module_id, $perm_name, 0); 
    /*
	*  Save the new permissions
	*/ 
    if (is_array($groups))
    {
        foreach ($groups as $group_id)
        {
            $gperm_handler -> addRight($perm_name, 0, $group_id, $module_id);
        } 
    } 
    return $result;
} 

?>