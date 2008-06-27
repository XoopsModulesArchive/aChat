<?php
// $Id: achat_tpl.php, see below 
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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
// v 0.2 2006/08/24 21:39:37
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

$aChat_url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname');
$achat_module_header = '<link rel="stylesheet" type="text/css" href="'.$aChat_url.'/templates/aChat.css" />
<script type="text/javascript">
	var aChat_url = "' .XOOPS_URL.'/modules/aChat";
	var aChat_tmp_refresh = '.$xoopsModuleConfig['tmp_refresh'].';
</script>
<script src="'.$aChat_url.'/include/js/XHRConnection.js" type="text/javascript"></script>
<script src="'.$aChat_url.'/include/js/aChat_functions.js" type="text/javascript"></script>';

//$xoopsOption['xoops_module_header'] = $achat_module_header;
$xoopsTpl->assign('xoops_module_header', $achat_module_header);

if(isset($postmessage)) $xoopsTpl->assign('postmessage',$postmessage);

$xoopsTpl->assign('messages',$messages);

// Gestion des droits d'envoie des messages
$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule->getVar('mid');
$gperm_handler = &xoops_gethandler('groupperm');

$achat_form = '';
if ($gperm_handler->checkRight('aChatCanPost', 0 , $groups, $module_id)) {
	include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/achat_form.php";
	$achat_form = $aform->render();
}

$xoopsTpl->assign('achat_form', $achat_form);
?>