<?php
// $Id: admin_header.php, see below 
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

// Cr�� par Niluge_Kiwi
// v 0.232 2007/10/12 22:44:21
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//


include_once '../../../mainfile.php';
include_once '../../../include/cp_header.php';
include_once '../../../include/functions.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsmodule.php';
include_once './functions.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php'; 

	if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once XOOPS_ROOT_PATH . '/modules/'.$xoopsModule->dirname().'/language/french/modinfo.php';
	}
	
$myts = &MyTextSanitizer::getInstance();
$msgobj_h =& xoops_getmodulehandler('message');

?>
