<?php
// $Id: admin.php, see below 
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
// v 0.2 2007/08/12 23:23:53
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

// Menu
define("_AM_ACHAT_MODULEADMIN", "Module Admin:");

define("_AM_ACHAT_CREDIT", "aChat 0.2 is an original creation of Niluge_KiWi<br />(c) Jully-Augustus 2006");

// Home
define("_AM_ACHAT_WELCOME", "Welcome to the aChat module admin.");
define("_AM_ACHAT_NBRE_MSG", "Number of messages in the database");
define("_AM_ACHAT_MESSAGES", "messages");
define("_AM_ACHAT_EMPTY_FIELD", "Please fill the field(s).");

// Permissions
define("_AM_ACHAT_PERM_CANPOST", "Can post messages");

// Purge
define("_AM_ACHAT_PURGEPERNBRE", "Purge per number of messages");
define("_AM_ACHAT_PURGE_HOWMANY", "Purge how many messages?");
define("_AM_ACHAT_PURGE_CREATELOG", "Create a logfile with the purged messages?");
define("_AM_ACHAT_PURGE_VALIDATE", "Are you sure to want to purge&nbsp;");
define("_AM_ACHAT_PURGE_SUPPR_NOLOG", "without logfile");
define("_AM_ACHAT_PURGE_ERROR_WRITEFILE", "An error appeared during the creation of the logfile. Please verify that the folder on the module parameters is correct and that there are the good rights on it.");
define("_AM_ACHAT_PURGE_LOG_WRITTEN", "Logfile created.");
define("_AM_ACHAT_PURGE_CANCELED", "Purge Canceled.");
define("_AM_ACHAT_PURGE_OK", "Purge OK.");
define("_AM_ACHAT_PURGE_NBREMSGDEL", "Number of deleted messages: ");
define("_AM_ACHAT_PURGE_ERROR", "An error appeared during the purge.");
define("_AM_ACHAT_PURGEPERDATE", "Purge per date");
define("_AM_ACHAT_PURGE_KEEP_HMDAYS", "Keep messages from the last x days");
define("_AM_ACHAT_PURGE_VALIDATE_PERDAY", "the messages posted before");
define("_AM_ACHAT_PURGE_VALIDATE_PERDAY2", " last days");
define("_AM_ACHAT_PURGE_NOMSG", "No message to delete.");

// Delete Messages
define("_AM_ACHAT_DELETEMSG", "Delete a message");
define("_AM_ACHAT_DELETEMSG_MID", "mid of the message to delete<br />(last number displayed when you put the mouse on the poster pseudo,<br /> only displayed for admins)");
define("_AM_ACHAT_DELETEMSG_OK", "Message number %u deleted.");
define("_AM_ACHAT_DELETEMSG_ERROR", "An error has occured when deleting message number %u.");

// Utilities ( Clone ) ( from myHome module )
define("_AM_ACHAT_CLONE", "Module cloning");

define("_AM_ACHAT_CLONENAME", "Clone name<br /><i>
                                         <ul>
                                             <li>Not more than 16 characters</li>
                                             <li>No special characters</li>
                                             <li>No already existing module name</li>
                                             <li>Capitals and spaces accepted</li>
                                         </ul></i>
                                         Sample: 'My Module 01'. ");

define("_AM_ACHAT_SUBMIT", "Clone!");
define("_AM_ACHAT_CLEAR", "Delete");
define("_AM_ACHAT_CANCEL", "Cancel");

define("_AM_ACHAT_CLONED", "Module successfully cloned");
define("_AM_ACHAT_MODULEXISTS", "This module already exists");
define("_AM_ACHAT_NOTCLONED",  "Clone settings are uncorrect");
define("_AM_ACHAT_CLONE_TROUBLE", "Settings of your web host do not allow the cloning operation.
					 Please retry on a server which allow permissions change on the server.
                                         (For instance, on a local server)");
?>