<?php
// $Id: modinfo.php, see below 
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

// Créé par Niluge_Kiwi, corrigé par vpxavier <vpxavier@gmail.com>
// v 0.232 2007/10/31 23:23:53
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
define('_MI_ACHAT_NAME', 'aChat');
// A brief description of this module
define('_MI_ACHAT_DESC','A module for Chatting, a TagBoard with AJAX!');

// Menu
define("_MI_ACHAT_HOME", "Home");
define("_MI_ACHAT_PURGE", "Purge");
define("_MI_ACHAT_PERM", "Permissions");
define("_MI_ACHAT_UTILITIES", "Utilities");

define("_MI_ACHAT_SMNAME1","View logs");
define("_MI_ACHAT_SMNAME2","View archives");

define("_MI_ACHAT_GOTO_INDEX","Go to module");
define("_MI_ACHAT_HELP","Help");

// Templates
define('_MI_ACHAT_TDESC0',"Main template for main display.");
define('_MI_ACHAT_TDESC1',"Template for messages display");
define('_MI_ACHAT_TDESC2',"Template for logs (purge function)");

// Blocks
define('_MI_ACHAT_BNAME1','aChat');
define('_MI_ACHAT_BDESC1','Block which displays the aChat');
define('_MI_ACHAT_BNAME2','Static aChat');
define('_MI_ACHAT_BDESC2',"Preview block with lasts messages, without autorefresh and send form");

// Config
define('_MI_ACHAT_NBRE_MSG_AFF','Number of messages to display');
define('_MI_ACHAT_NBRE_MSG_AFFDSC','Number of messages to display on the aChat module\'s page(index.php)');

define('_MI_ACHAT_TMP_REFRESH','Refresh time');
define('_MI_ACHAT_TMP_REFRESHDSC','(seconds)<br /> You can put float number, for example 1.5, but a number given to three decimal place max!(otherwise javascript bug.)');

define('_MI_ACHAT_USER_SMILIES','Use the smilies?');
define('_MI_ACHAT_USE_BBCODES','Use the BBCodes?');

define('_MI_ACHAT_ALLOWED_COLORS','Available colors for the messages');
define('_MI_ACHAT_ALLOWED_COLORSDESC','Color in RGB hexa format, separated by |, and without #.<br />Example : "000000|FFFFFF" will allow Black and White colors<br />Empty for the 8 default colors.');

define('_MI_ACHAT_PURGE_FOLDER','Folder for logs (with purge function)');
define('_MI_ACHAT_PURGE_FOLDERDESC','Empty to use the default folder (modules/aChat/logs)');

define('_MI_ACHAT_NICK4GUESTS','Anonymous users can choose their nickname');
define('_MI_ACHAT_NICK4GUESTSDESC',"Anonymous users nicknames are displayed in grey (can be modified on modules/aChat/templates/aChat.css)");
?>
