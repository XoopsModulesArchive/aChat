<?php
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

// Cr殚 par Niluge_Kiwi
// v 0.2 2006/08/25 20:11:36
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

// Module Info

// The name of this module
define('_MI_ACHAT_NAME', '聊天室');
// A brief description of this module
define('_MI_ACHAT_DESC','聊天室模块, 使用AJAX!');

// Menu
define("_MI_ACHAT_HOME", "首页");
define("_MI_ACHAT_PURGE", "清除");
define("_MI_ACHAT_PERM", "权限");
define("_MI_ACHAT_UTILITIES", "实用工具");

define("_MI_ACHAT_SMNAME1","查看聊天记录");
define("_MI_ACHAT_SMNAME2","查看存档");

define("_MI_ACHAT_GOTO_INDEX","跳到模块首页");
define("_MI_ACHAT_HELP","帮助");

// Templates
define('_MI_ACHAT_TDESC0',"主显示的主模板.");
define('_MI_ACHAT_TDESC1',"显示消息的模板");
define('_MI_ACHAT_TDESC2',"logs模板(清除功能))");

// Blocks
define('_MI_ACHAT_BNAME1','聊天室');
define('_MI_ACHAT_BDESC1','显示聊天室的区块');
define('_MI_ACHAT_BNAME2','静态聊天室');
define('_MI_ACHAT_BDESC2',"用最近的消息预览区块, 不需要自动刷新和发送表单");

// Config
define('_MI_ACHAT_NBRE_MSG_AFF','要显示的消息数');
define('_MI_ACHAT_NBRE_MSG_AFFDSC','聊天室模块首页(index.php)要显示的消息数');

define('_MI_ACHAT_TMP_REFRESH','刷新时间');
define('_MI_ACHAT_TMP_REFRESHDSC','(秒)<br /> 你可以输入浮点数，如1.5, 但小数位最多三位!(否则会出现javascript bug.)');

define('_MI_ACHAT_USER_SMILIES','使用表情图标?');
define('_MI_ACHAT_USE_BBCODES','使用BBCodes?');

define('_MI_ACHAT_ALLOWED_COLORS','消息可用颜色');
define('_MI_ACHAT_ALLOWED_COLORSDESC','十六进制的RGB颜色值, 用竖线|分隔, 前面不需要井号#.<br />如 : "000000|FFFFFF" 将会允许使用黑色和白色<br />留空则有8个默认颜色.');

define('_MI_ACHAT_PURGE_FOLDER','logs文件夹 (清除消息时用的)');
define('_MI_ACHAT_PURGE_FOLDERDESC','留空则使用默认的文件夹 (uploads/achat)');

define('_MI_ACHAT_NICK4GUESTS','游客可以选择昵称');
define('_MI_ACHAT_NICK4GUESTSDESC',"游客昵称将用灰色显示(可以通过这个文件修改：modules/aChat/templates/aChat.css)");
?>
