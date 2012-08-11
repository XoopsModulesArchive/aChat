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

// Cr�� par Niluge_Kiwi
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
define("_AM_ACHAT_MODULEADMIN","ģ�����:");

define("_AM_ACHAT_CREDIT","aChat 0.2 is an original creation of Niluge_KiWi<br />(c) Jully-Augustus 2006");

// Home
define("_AM_ACHAT_WELCOME","��ӭ����aChatģ������̨.");
define("_AM_ACHAT_NBRE_MSG","���ݿ��е���Ϣ��");
define("_AM_ACHAT_MESSAGES","��Ϣ");
define("_AM_ACHAT_EMPTY_FIELD","����д���.");

// Permissions
define("_AM_ACHAT_PERM_CANPOST","���Է�����Ϣ");

// Purge
define("_AM_ACHAT_PURGEPERNBRE","����Ϣ�����");
define("_AM_ACHAT_PURGE_HOWMANY","�����������Ϣ?");
define("_AM_ACHAT_PURGE_CREATELOG","Ϊ���������Ϣ����һ�������¼����?");
define("_AM_ACHAT_PURGE_VALIDATE","ȷ��Ҫ���&nbsp;");
define("_AM_ACHAT_PURGE_SUPPR_NOLOG","��Ҫlogfile");
define("_AM_ACHAT_PURGE_ERROR_WRITEFILE","����logfileʱ���ִ���. ��ȷ����ģ����������õ��ļ��д��ڣ����к��ʵ�Ȩ��.");
define("_AM_ACHAT_PURGE_LOG_WRITTEN","�����¼�����Ѵ���.");
define("_AM_ACHAT_PURGE_CANCELED","���������ȡ��.");
define("_AM_ACHAT_PURGE_OK","����ɹ�.");
define("_AM_ACHAT_PURGE_NBREMSGDEL","�Ѿ�ɾ������Ϣ��: ");
define("_AM_ACHAT_PURGE_ERROR","���ʱ���ִ���.");
define("_AM_ACHAT_PURGEPERDATE","���������");
define("_AM_ACHAT_PURGE_KEEP_HMDAYS","������� x �����Ϣ");
define("_AM_ACHAT_PURGE_VALIDATE_PERDAY","��xx֮ǰ�������Ϣ");
define("_AM_ACHAT_PURGE_VALIDATE_PERDAY2"," last days");
define("_AM_ACHAT_PURGE_NOMSG","û�п�ɾ������Ϣ.");

// Delete Messages
define("_AM_ACHAT_DELETEMSG","Supprimer un message");
define("_AM_ACHAT_DELETEMSG_MID","Mid du message ?supprimer<br />(dernier num&eacute;ro affich&eacute; lors du survol du pseudo du posteur du message,<br /> visible uniquement par les admin)");
define("_AM_ACHAT_DELETEMSG_OK","Message num&eacute;ro %u supprim&eacute;.");
define("_AM_ACHAT_DELETEMSG_ERROR","Une erreur est survenue lors de la suppression du message num�ro %u.");

// Utilities ( Clone ) ( from myHome module )
define("_AM_ACHAT_CLONE","ģ���¡");

define("_AM_ACHAT_CLONENAME","��¡����<br /><i>
                                         <ul>
                                             <li>��Ҫ����16���ַ�</li>
                                             <li>�����������ַ�</li>
                                             <li>����������ģ�������</li>
                                             <li>�����ô�д�Ϳո�</li>
                                         </ul></i>
                                         ����: 'My Module 01'. ");

define("_AM_ACHAT_SUBMIT",	"��¡!");
define("_AM_ACHAT_CLEAR",	"ɾ��");
define("_AM_ACHAT_CANCEL",	"ȡ��");

define("_AM_ACHAT_CLONED","ģ���ѳɹ���¡");
define("_AM_ACHAT_MODULEXISTS","���ģ���Ѿ�����");
define("_AM_ACHAT_NOTCLONED","��¡��������");
define("_AM_ACHAT_CLONE_TROUBLE","���ķ��������ò������¡����.
					 ����һ�����Ը���Ȩ�޵ķ��������²���.
                                         (����, ���ط�����)");
?>