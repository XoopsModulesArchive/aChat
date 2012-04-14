<?php
// $Id: xoops_version.php, see below
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
// v 0.232 2007/10/12 22:38:22
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
$modversion['name'] = _MI_ACHAT_NAME;
$modversion['version'] = 0.232;
$modversion['description'] = _MI_ACHAT_DESC;
$modversion['credits'] = "Niluge_KiWi Projects";
$modversion['author'] = "Thomas Riccardi, alias Niluge_KiWi";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/aChat_slogo.png";
$modversion['dirname'] = "aChat";



// XoopsInfo
$modversion['developer_website_url'] 	= "http://xoops-demo.niluge-kiwi.info/";
$modversion['developer_website_name']	= "Niluge_KiWi's website";
$modversion['download_website']			= "http://xoops-demo.niluge-kiwi.info/modules/mydownloads/";
$modversion['status_fileinfo'] 			= "http://xoops-demo.niluge-kiwi.info/aChat.version";
$modversion['status_version']				= "beta";
$modversion['status']						= "";
$modversion['date']							= "";
$modversion['demo_site_url']				= "http://niluge.kiwi.free.fr/xoops/modules/aChat/";
$modversion['demo_site_name']				= "Xoops-demo aChat by Niluge_KiWi";
$modversion['support_site_url']			= "http://xoops-demo.niluge-kiwi.info/modules/contact/";
$modversion['support_site_name']			= "Niluge_KiWi's website";
$modversion['submit_bug']					= "http://xoops-demo.niluge-kiwi.info/modules/contact/";
$modversion['submit_feature'] 			= "http://xoops-demo.niluge-kiwi.info/modules/contact/";
// End XoopsInfo

$modversion['onUpdate'] = 'update/achat01_to_achat02.php';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1] = array(
	'name' => _MI_ACHAT_SMNAME1,
	'url' => 'viewlogs.php');

$modversion['sub'][] = array(
	'name' => _MI_ACHAT_SMNAME2,
	'url' => 'viewarchives.php');


// Sql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables
$modversion['tables'][0] = "achat_messages";

// Module css
$modversion['css'] = 'templates/aChat.css';

// Templates
$modversion['templates'][1] = array(
	'file' => 'achat_display.html',
	'description' => _MI_ACHAT_TDESC0);

$modversion['templates'][] = array(
	'file' => 'achat_postmessage.html',
	'description' => _MI_ACHAT_TDESC1);

$modversion['templates'][] = array(
	'file' => 'achat_viewlogs.html',
	'description' => _MI_ACHAT_TDESC2);

// Blocks
$modversion['blocks'][1] = array(
	'file' => 'achat_display.php',
	'name' => _MI_ACHAT_BNAME1,
	'description' => _MI_ACHAT_BDESC1,
	'show_func' => 'b_achat_display_show',
	'edit_func' => 'b_achat_display_edit',
	'options' => '1|10|180|1.5|23',
	'template' => 'achat_block_display.html');

$modversion['blocks'][] = array(
	'file' => 'achat_display.php',
	'name' => _MI_ACHAT_BNAME2,
	'description' => _MI_ACHAT_BDESC2,
	'show_func' => 'b_achat_display_show',
	'edit_func' => 'b_achat_display_edit',
	'options' => '0|10',
	'template' => 'achat_block_static.html');

// Config
$modversion['config'][1] = array(
	'name' => 'nbre_msg_aff',
	'title' => '_MI_ACHAT_NBRE_MSG_AFF',
	'description' => '_MI_ACHAT_NBRE_MSG_AFFDSC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' => 25,
	'category' => 'aChat_settings');

$modversion['config'][] = array(
	'name' => 'tmp_refresh',
	'title' => '_MI_ACHAT_TMP_REFRESH',
	'description' => '_MI_ACHAT_TMP_REFRESHDSC',
	'formtype' => 'textbox',
	'valuetype' => 'float',
	'default' => 1.5,
	'category' => 'aChat_settings');

$modversion['config'][] = array(
	'name' => 'use_smilies',
	'title' => '_MI_ACHAT_USER_SMILIES',
	'description' => '',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1,
	'category' => 'aChat_settings');

$modversion['config'][] = array(
	'name' => 'use_bbcodes',
	'title' => '_MI_ACHAT_USE_BBCODES',
	'description' => '',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1,
	'category' => 'aChat_settings');

$modversion['config'][] = array(
	'name' => 'allowed_colors',
	'title' => '_MI_ACHAT_ALLOWED_COLORS',
	'description' => '_MI_ACHAT_ALLOWED_COLORSDESC',
	'formtype' => 'textarea',
	'valuetype' => 'array',
	'default' => array(
		'0' => '000000',
		'1' => 'dc0000',
		'2' => '4cb5e8',
		'3' => '6600cc',
		'4' => '336600',
		'5' => '000099',
		'6' => 'ff6600',
		'7' => '660000'),
	'category' => 'aChat_settings');

$modversion['config'][] = array(
	'name' => 'nick4guests',
	'title' => '_MI_ACHAT_NICK4GUESTS',
	'description' => '_MI_ACHAT_NICK4GUESTSDESC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => 1,
	'category' => 'aChat_settings');

$modversion['config'][] = array(
	'name' => 'purge_folder',
	'title' => '_MI_ACHAT_PURGE_FOLDER',
	'description' => '_MI_ACHAT_PURGE_FOLDERDESC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' => 'modules/aChat/logs',
	'category' => 'aChat_settings');
?>
