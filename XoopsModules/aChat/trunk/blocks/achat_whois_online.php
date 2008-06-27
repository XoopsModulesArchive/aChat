<?php
// $Id: achat_whois_online.php, see below
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
// v 0.22 2006/09/01 16:24:28
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

// include the default language file
if ( !@include_once(XOOPS_ROOT_PATH."/modules/aChat/language/" . $xoopsConfig['language'] . "/main.php")){
    include_once(XOOPS_ROOT_PATH."/modules/aChat/language/english/main.php");
}


function b_achat_whois_online_show($options) {
    // Modified from online system block
    global $xoopsUser, $xoopsModule;
    $online_handler =& xoops_gethandler('online');
    mt_srand((double)microtime()*1000000);
    // Ajouts
    // temps d'actualisation
    $refreshtime = !is_null(intval($options[0])) ? intval($options[0]) : 300;
    $online_handler->gc($refreshtime);

    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');
        $uname = $xoopsUser->getVar('uname');
    } else {
        $uid = 0;
        $uname = '';
    }

    $online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);

    $onlines =& $online_handler->getAll();
    if (false != $onlines) {
        $total = count($onlines);
        $block = array();
        $guests = 0;
        $members = '';
        for ($i = 0; $i < $total; $i++) {
            if ($onlines[$i]['online_uid'] > 0) {
                $members .= ' <a href="'.XOOPS_URL.'/userinfo.php?uid='.$onlines[$i]['online_uid'].'">'.$onlines[$i]['online_uname'].'</a>,';
            } else {
                $guests++;
            }
        }
        $block['online_total'] = sprintf(_ONLINEPHRASE, $total);
        if (is_object($xoopsModule)) {
            $mytotal = $online_handler->getCount(new Criteria('online_module', $xoopsModule->getVar('mid')));
            $block['online_total'] .= ' ('.sprintf(_ONLINEPHRASEX, $mytotal, $xoopsModule->getVar('name')).')';
        }
        $block['lang_members'] = _MEMBERS;
        $block['lang_guests'] = _GUESTS;
        $block['online_names'] = $members;
        $block['online_members'] = $total - $guests;
        $block['online_guests'] = $guests;
        $block['lang_more'] = _MORE;
        return $block;
    } else {
        return false;
    }
}

function b_achat_whois_online_edit($options) {
    $form = _MB_ACHAT_TMP_REFRESH.":&nbsp;<input type='text' name='options[0]' size='4' value='".$options[0]."' /><br />&nbsp;&nbsp;"._MB_ACHAT_TMP_REFRESHDESC;
    return $form;
}
?>
