<?php
// $Id: header.php, see below
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

// Cr�� par Niluge_Kiwi
// v 0.2 2006/08/15 23:12:22
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

include_once "../../mainfile.php";

if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.php";
include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/class/formachat.php";

$msgobj_h =& xoops_getmodulehandler('message');

$aChat_url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname');
$achat_module_header = '<link rel="stylesheet" type="text/css" href="'.$aChat_url.'/templates/aChat.css" />';
$achat_module_header .= '
<script type="text/javascript">
	var aChat_url = "' .XOOPS_URL.'/modules/aChat";
	var aChat_tmp_refresh = '.$xoopsModuleConfig['tmp_refresh'].';
</script>';
$achat_module_header .= '<script src="'.$aChat_url.'/include/js/XHRConnection.js" type="text/javascript"></script>';
$achat_module_header .= '<script src="'.$aChat_url.'/include/js/aChat_functions.js" type="text/javascript"></script>';
?>