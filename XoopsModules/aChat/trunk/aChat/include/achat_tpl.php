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
// v 0.232 2007/10/30 13:58:39
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

aChat_JS_CSS_Headers($xoopsModuleConfig['tmp_refresh']);

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
