<?php
// $Id: index.php, see below
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
// v 0.23 2007/08/13 23:05:18
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
include "./header.php";

// Si c'est une requete d'insertion, on insert le message!
if(isset($_POST['achat_input'])) {
    // Gestion des droits d'envoie des messages
    $groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $module_id = $xoopsModule->getVar('mid');
    $gperm_handler = &xoops_gethandler('groupperm');
    // Si le visiteur a le droit de poster, on enregistre le message
    if ($gperm_handler->checkRight('aChatCanPost', 0 , $groups, $module_id)) {
        // Message en fonction du bon déroulement ou non de l'enregistrement du message.
        $postmessage = $msgobj_h->processPostRequest() ? '' : 'Error: message not saved';
    }
}

// Si c'est une requete AJAX d'actualisation ou un post avec AJAX, on renvoie les nouveaux messages
if( isset($_POST['achat_ajax_refresh']) || isset($_POST['achat_ajax_submit'])) {
    include XOOPS_ROOT_PATH.'/header.php';

    $lastmid = intval($_POST['achat_lastmid']);
    $messages = $msgobj_h->getMessages('from', $lastmid);

    // debug message d'erreur : mettre ceci dans l'url, puis valider: (ça affiche la div temporaire)
    //      javascript:changeAffichage('achat_div_temp');
    // et décommenter la ligne si dessous (retirer les //)
    //     if(isset($postmessage)) $xoopsTpl->assign('postmessage',$postmessage);

    $xoopsTpl->assign('messages',$messages);
    $xoopsTpl->assign('ajax_display',1);

    // Désactivation des messages d'erreur 
    // - Pour xoops <= 2.0.13.2
    // - Pour xoops >= 2.0.14
    if(method_exists($xoopsErrorHandler, 'activate')) {
        $xoopsErrorHandler->activate(false);
    } else {
        $xoopsLogger->activated = false;
    }

    //Gestion charset avec header :
    if (!headers_sent()) {
        header('Content-Type:text/html; charset='._CHARSET);
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        //header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Cache-Control: private, no-cache');
        header('Pragma: no-cache');
    }

    //Affichage final avec smarty
    $xoopsTpl->display('db:achat_display.html');
    exit;
}

// Si c'est une ouverture normale de la page, ou un post sans AJAX, on affiche les messages
else {
    $xoopsOption['template_main'] = 'achat_display.html';
    include XOOPS_ROOT_PATH.'/header.php';

    $messages = $msgobj_h->getMessages('last', $xoopsModuleConfig['nbre_msg_aff']);
    include "./include/achat_tpl.php";

    include(XOOPS_ROOT_PATH."/footer.php");
}
?>
