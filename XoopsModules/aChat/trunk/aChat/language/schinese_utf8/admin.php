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

// Cr殚 par Niluge_Kiwi
// v 0.2 2006/08/25 20:11:53
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

// Menu
define("_AM_ACHAT_MODULEADMIN","模块管理:");

define("_AM_ACHAT_CREDIT", "aChat 0.2 is an original creation of Niluge_KiWi<br />(c) Jully-Augustus 2006");

// Home
define("_AM_ACHAT_WELCOME", "欢迎来到aChat模块管理后台.");
define("_AM_ACHAT_NBRE_MSG", "数据库中的消息数");
define("_AM_ACHAT_MESSAGES", "消息");
define("_AM_ACHAT_EMPTY_FIELD", "请填写表单.");

// Permissions
define("_AM_ACHAT_PERM_CANPOST", "可以发送消息");

// Purge
define("_AM_ACHAT_PURGEPERNBRE", "按消息数清除");
define("_AM_ACHAT_PURGE_HOWMANY", "清除多少条消息?");
define("_AM_ACHAT_PURGE_CREATELOG", "为被清除的消息创建一个聊天记录档案?");
define("_AM_ACHAT_PURGE_VALIDATE", "确定要清除&nbsp;");
define("_AM_ACHAT_PURGE_SUPPR_NOLOG", "不要logfile");
define("_AM_ACHAT_PURGE_ERROR_WRITEFILE", "创建logfile时出现错误. 请确认在模块参数种设置的文件夹存在，并有合适的权限.");
define("_AM_ACHAT_PURGE_LOG_WRITTEN", "聊天记录档案已创建.");
define("_AM_ACHAT_PURGE_CANCELED", "清除动作已取消.");
define("_AM_ACHAT_PURGE_OK", "清除成功.");
define("_AM_ACHAT_PURGE_NBREMSGDEL", "已经删除的消息数: ");
define("_AM_ACHAT_PURGE_ERROR", "清除时出现错误.");
define("_AM_ACHAT_PURGEPERDATE", "按天数清除");
define("_AM_ACHAT_PURGE_KEEP_HMDAYS", "保留最近 x 天的消息");
define("_AM_ACHAT_PURGE_VALIDATE_PERDAY", "在xx之前发表的消息");
define("_AM_ACHAT_PURGE_VALIDATE_PERDAY2", " last days");
define("_AM_ACHAT_PURGE_NOMSG", "没有可删除的消息.");

// Delete Messages
define("_AM_ACHAT_DELETEMSG","Supprimer un message");
define("_AM_ACHAT_DELETEMSG_MID","Mid du message ?supprimer<br />(dernier num&eacute;ro affich&eacute; lors du survol du pseudo du posteur du message,<br /> visible uniquement par les admin)");
define("_AM_ACHAT_DELETEMSG_OK","Message num&eacute;ro %u supprim&eacute;.");
define("_AM_ACHAT_DELETEMSG_ERROR","Une erreur est survenue lors de la suppression du message num閞o %u.");

// Utilities ( Clone ) ( from myHome module )
define("_AM_ACHAT_CLONE", "模块克隆");

define("_AM_ACHAT_CLONENAME", "克隆名称<br /><i>
                                         <ul>
                                             <li>不要超过16个字符</li>
                                             <li>不能用特殊字符</li>
                                             <li>不能用已有模块的名称</li>
                                             <li>可以用大写和空格</li>
                                         </ul></i>
                                         例如: 'My Module 01'. ");

define("_AM_ACHAT_SUBMIT",	"克隆!");
define("_AM_ACHAT_CLEAR",	"删除");
define("_AM_ACHAT_CANCEL",	"取消");

define("_AM_ACHAT_CLONED", "模块已成功克隆");
define("_AM_ACHAT_MODULEXISTS", "这个模块已经存在");
define("_AM_ACHAT_NOTCLONED", "克隆设置有误");
define("_AM_ACHAT_CLONE_TROUBLE", "您的服务器设置不允许克隆操作.
					 请在一个可以更改权限的服务器重新测试.
                                         (例如, 本地服务器)");
?>