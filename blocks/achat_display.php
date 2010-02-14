<?php
// $Id: achat_display.php, see below
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
// v 0.232 2007/10/30 13:58:22
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


function b_achat_display_show($options) {
    // Cette fonction gère les 2 blocs : 
    // - l'actif avec autorefresh et envoie de messages
    // - et le passif avec seulement affichage statique des derniers messages

    global $xoopsUser;

    // Gestion du type de bloc
    $isactive = $options[0] == 1 ? true : false;
    $myts = &MyTextSanitizer::getInstance();

    $msgobj_h =& xoops_getmodulehandler('message','aChat');
    include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
    include_once XOOPS_ROOT_PATH."/modules/aChat/include/functions.php";
    if($isactive) {
        include_once XOOPS_ROOT_PATH."/modules/aChat/class/formachat.php";
    }

    $block = array();



    // Gestion des variables javascript et css si bloc actif
    if($isactive) {
        if(!empty($options[3])) {
            //$block['tmp_refresh']
            $tmp_refresh = floatval($options[3]);
        } else {
            $tmp_refresh = getmoduleoptionNK('tmp_refresh');
            $tmp_refresh = !empty($tmp_refresh) ? intval($tmp_refresh) : 15;
        }
        $block['div_height'] = !empty($options[2]) ? intval($options[2]) : 180;

        aChat_JS_CSS_Headers($tmp_refresh);
    }
    // Nombre de messages affichés
    $n = !empty($options[1]) ? intval($options[1]) : getmoduleoptionNK('nbre_msg_aff');

    // Récupération des messages
    $messages = $msgobj_h->getMessages('last', $n);

    $block['messages'] = $messages;

    if($isactive) {
        $textformsize = !empty($options[4]) ? intval($options[4]) : 23;

        // Gestion des droits d'envoie des messages
        $groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

        $Module_handler =& xoops_gethandler('module');
        $Module =& $Module_handler -> getByDirname('aChat');
        $module_id = $Module -> getVar('mid');
        $gperm_handler = &xoops_gethandler('groupperm');

        $block['achat_form'] = '';
        if ($gperm_handler->checkRight('aChatCanPost', 0 , $groups, $module_id)) {
            include XOOPS_ROOT_PATH."/modules/aChat/include/achat_form.php";
            $block['achat_form'] = $aform->render();
        }
    }

    return $block;
}

function b_achat_display_edit($options) {
    $form = "<input type='hidden' name='options[0]' value='".$options[0]."' />";
    $form .= "&nbsp;"._MB_ACHAT_NBRE_MSG_AFFICHE.":&nbsp;<input type='text' name='options[1]' size='4' value='".$options[1]."' /><br />&nbsp;&nbsp;"._MB_ACHAT_NBRE_MSG_AFFICHEDESC;
    if($options[0] == 1) {
        $form .= "<br />&nbsp;"._MB_ACHAT_DIV_HEIGHT.":&nbsp;<input type='text' name='options[2]' size='4' value='".$options[2]."' /><br />&nbsp;&nbsp;"._MB_ACHAT_DIV_HEIGHTDESC;
        $form .= "<br />&nbsp;"._MB_ACHAT_TMP_REFRESH.":&nbsp;<input type='text' name='options[3]' size='4' value='".$options[3]."' /><br />&nbsp;&nbsp;"._MB_ACHAT_TMP_REFRESHDESC;
        $form .= "<br />&nbsp;"._MB_ACHAT_DIV_WIDTH.":&nbsp;<input type='text' name='options[4]' size='4' value='".$options[4]."' /><br />&nbsp;&nbsp;"._MB_ACHAT_DIV_WIDTHDESC;
    }
    return $form;
}
?>
