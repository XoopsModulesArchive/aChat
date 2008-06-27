<?php
// $Id: menu.php, see below
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


// Crיי par Niluge_Kiwi
// v 0.2 2006/08/23 19:06:27
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
$i = 0;
$adminmenu[$i]['title'] = _MI_ACHAT_HOME;
$adminmenu[$i++]['link'] = "admin/index.php";
$adminmenu[$i]['title'] = _MI_ACHAT_PURGE;
$adminmenu[$i++]['link'] = "admin/index.php?op=purge";
$adminmenu[$i]['title'] = _MI_ACHAT_PERM;
$adminmenu[$i++]['link'] = "admin/index.php?op=perm";
$adminmenu[$i]['title'] = _MI_ACHAT_UTILITIES;
$adminmenu[$i++]['link'] = "admin/utilities.php";

if (isset($xoopsModule)) {
  $i = 0;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i++]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$headermenu[$i]['title'] = _MI_ACHAT_GOTO_INDEX;
	$headermenu[$i++]['link'] = XOOPS_URL . '/modules/'.$xoopsModule->getVar('dirname').'/';

	$headermenu[$i]['title'] = _MI_ACHAT_HELP;
	$headermenu[$i++]['link'] = "help.php";
}
?>