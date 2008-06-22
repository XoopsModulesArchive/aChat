<?php
// $Id: viewlogs.php, see below
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

// Crיי par Niluge_Kiwi
// v 0.2 2006/08/29 23:05:37
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
include("header.php");

$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
$limit = isset($_GET['perpage']) ? intval($_GET['perpage']) : 30;
$limit = empty($limit) ? 30 : $limit;
//$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
$order = (@$_GET['order'] == 'ASC') ? 'ASC' : 'DESC';
$criteria = new Criteria("mid", 0, ">");
$criteria->setLimit($limit);
$criteria->setOrder($order);
$criteria->setStart($start);

$msgobjs =& $msgobj_h->getObjects($criteria);
$count = $msgobj_h->getCount($criteria);
$messages = $msgobj_h->getMessagesForDisplay($msgobjs);

include_once './class/mypagenavNK.php';


$xoopsOption['template_main'] = 'achat_viewlogs.html';
include XOOPS_ROOT_PATH.'/header.php';

$nav = new MyPageNavNK($count, $limit, $start, $order);
$xoopsTpl->assign('pagenav', $nav->renderAuto(5,true));
$xoopsTpl->assign('pagenav2', $nav->renderNav(5));
$xoopsTpl->assign('messages', $messages);


include(XOOPS_ROOT_PATH."/footer.php");
?>