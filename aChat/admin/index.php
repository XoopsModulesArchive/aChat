<?php
// $Id: index.php, see below
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
// v 0.232 2007/10/12 22:44:12
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

include './admin_header.php';

function achat() {

    global $xoopsUser, $xoopsDB, $xoopsConfig, $xoopsModule, $myts;

    xoops_cp_header();
    aChat_adminmenu( _MI_ACHAT_HOME, 0 );
    OpenTable();
    echo '<h1>' . _AM_ACHAT_WELCOME . '</h1>';

    echo '<div>'._AM_ACHAT_NBRE_MSG .':&nbsp;'. get_nbre_msg().'</div>';
    CloseTable();
    echo '<p />';
    // Delete form
    $sform = new XoopsThemeForm( _AM_ACHAT_DELETEMSG, 'op', 'index.php?op=deletemsg' );
    $sform->addElement( new XoopsFormText( _AM_ACHAT_DELETEMSG_MID, 'mid', 4, 6) );
    $sform->addElement( new XoopsFormButton( '', 'valide', _SUBMIT, 'submit') );
    $sform->display();

    include_once './admin_footer.php';
}

function deletemsg() {

    global $_POST;

    xoops_cp_header();
    aChat_adminmenu( _AM_ACHAT_DELETEMSG, -1 );

    $mid = isset($_POST['mid']) ? intval($_POST['mid']) : false;

    OpenTable();

    if($mid) {
        if(delete_msg($mid)) {
            echo sprintf(_AM_ACHAT_DELETEMSG_OK, $mid);
        } else {
            echo sprintf(_AM_ACHAT_DELETEMSG_ERROR, $mid);
        }
    } else {
        echo _AM_ACHAT_EMPTY_FIELD;
    }

    CloseTable();

    include_once './admin_footer.php';
}

function purge() {

    xoops_cp_header();
    aChat_adminmenu( _MI_ACHAT_PURGE, 1 );

    OpenTable();
    echo '<div>'._AM_ACHAT_NBRE_MSG .':&nbsp;'. get_nbre_msg().'</div>';
    CloseTable();
    echo '<p />';

    // Purge form
    $sform = new XoopsThemeForm( _AM_ACHAT_PURGEPERNBRE, 'op', 'index.php?op=purge2' );
    $sform->addElement( new XoopsFormText( _AM_ACHAT_PURGE_HOWMANY, 'number', 4, 6, 100) );
    $sform->addElement( new XoopsFormRadioYN( _AM_ACHAT_PURGE_CREATELOG, 'log', 1) );
    $sform->addElement( new XoopsFormButton( '', 'valide', _SUBMIT, 'submit') );
    $sform->display();

    echo '<p />';

    // Purge per date form
    $sform = new XoopsThemeForm( _AM_ACHAT_PURGEPERDATE, 'op', 'index.php?op=purge2' );
    $sform->addElement( new XoopsFormText( _AM_ACHAT_PURGE_KEEP_HMDAYS, 'daynumbers', 4, 6, 30) );
    $sform->addElement( new XoopsFormRadioYN( _AM_ACHAT_PURGE_CREATELOG, 'log', 1) );
    $sform->addElement( new XoopsFormButton( '', 'valide', _SUBMIT, 'submit') );
    $sform->display();


    include_once './admin_footer.php';

}

function purge2() {

    global $_POST, $msgobj_h;

    xoops_cp_header();
    aChat_adminmenu( _MI_ACHAT_PURGE, 1 );
    OpenTable();

    $number = isset($_POST['number']) ? $_POST['number'] : false;
    $daynumbers = isset($_POST['daynumbers'])? $_POST['daynumbers'] : false;
    if ( $number || $daynumbers) {

        $log = $_POST['log'];

        // 2em stade de purge : validation
        if ( !isset($_POST['validated']) ) {
            if( $log == 0 ) $msgsupp = '&nbsp;' ._AM_ACHAT_PURGE_SUPPR_NOLOG ;
            else $msgsupp = '';
            	
            // Purge par nombre :
            if($number) {
                $sform = new XoopsSimpleForm( _AM_ACHAT_PURGE_VALIDATE . '&nbsp;' . $number . '&nbsp;' . _AM_ACHAT_MESSAGES . $msgsupp . '?', 'op', 'index.php?op=purge2' );
            }
            // Purge par date :
            if($daynumbers) {
                $date = time() - $daynumbers * 24 * 60 * 60;
                $criteria = new Criteria("date",$date,"<");
                $number = $msgobj_h->getCount($criteria);

                $sform = new XoopsSimpleForm( _AM_ACHAT_PURGE_VALIDATE . '&nbsp;' . _AM_ACHAT_PURGE_VALIDATE_PERDAY . $daynumbers . _AM_ACHAT_PURGE_VALIDATE_PERDAY2 .' (' . $number . '&nbsp;' . _AM_ACHAT_MESSAGES .') ' . $msgsupp . '?', 'op', 'index.php?op=purge2' );
            }
            	
            // Si pas de messages à supprimer, on arrete tout 
            if($number == 0) {
                echo _AM_ACHAT_PURGE_NOMSG .'<br />'. _AM_ACHAT_PURGE_CANCELED;
                exit;
            }
            $sform->addElement( new XoopsFormHidden( 'number', $number) );
            $sform->addElement( new XoopsFormHidden( 'log', $log) );
            $sform->addElement( new XoopsFormHidden( 'validated', 1) );
            $sform->addElement( new XoopsFormButton( '', 'valide', _SUBMIT, 'submit') );
            $sform->display();

            // 3em stade de purge : purge effective
        } else {
            // Si logs demandé
            if ( $log == 1 ) {
                // On tente de créer le fichie logs!
                $file_url = purge_create_log($number);
                // Si le fichier n'a pas été créé, msg d'erreur.
                if ( !$file_url ) {
                    echo _AM_ACHAT_PURGE_ERROR_WRITEFILE .'<br />';
                } else {
                    echo _AM_ACHAT_PURGE_LOG_WRITTEN .':&nbsp;<a href="'. $file_url .'">'. $file_url .'</a><br />';
                }
            }
            	
            // Si la création du log a échouée, on annule la purge
            if(isset($file_url) && !$file_url) {
                echo _AM_ACHAT_PURGE_CANCELED;
            } else  {
                // Sinon on supprime les messages
                if (purge_msg($number)) {
                    echo _AM_ACHAT_PURGE_OK .'<br />'. _AM_ACHAT_PURGE_NBREMSGDEL.$number;
                } else {
                    echo _AM_ACHAT_PURGE_ERROR;
                }
            }
            echo '<div>'._AM_ACHAT_NBRE_MSG .':&nbsp;'. get_nbre_msg().'</div>';
        }
    } else {
        echo _AM_ACHAT_EMPTY_FIELD;
    }
    CloseTable();
    include_once './admin_footer.php';

}

function purge_create_log($n) {

    global $xoopsDB, $xoopsModuleConfig;

    $texte = aChat_exportTXT ($n);

    $purge_folder = rtrim (ltrim($xoopsModuleConfig['purge_folder'], '/'), '/');
    $rep = empty($purge_folder) ? XOOPS_ROOT_PATH.'/modules/aChat/logs' : XOOPS_ROOT_PATH.'/'.$purge_folder;

    $result = $xoopsDB -> query( "SELECT date FROM " . $xoopsDB -> prefix( "achat_messages" ) . " ORDER BY mid ASC", 1 );
    list( $startdate ) = $xoopsDB->fetchRow( $result );
    $result = $xoopsDB -> query( "SELECT date FROM " . $xoopsDB -> prefix( "achat_messages" ) . " ORDER BY mid ASC", 1, intval($n)-1 );
    list( $enddate ) = $xoopsDB->fetchRow( $result );

    $file = 'aChat_logs_-_';
    $file .= $startdate .'_to_'. $enddate .'.html';
    $name = $rep.'/'.$file;
    if(create_file($name, $texte)) {
        $rep2 = empty($purge_folder) ? XOOPS_URL.'/modules/aChat/logs' : XOOPS_URL.'/'.$purge_folder;
        return $rep2.'/'.$file;
    }
    return false;
}

function perm() {

    global $xoopsModule;
    include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

    xoops_cp_header();
    aChat_adminmenu( _MI_ACHAT_PERM, 2 );

    $module_id = $xoopsModule->getVar('mid');

    $perm_form = new XoopsGroupPermForm('', $module_id, 'aChatCanPost', '', 'admin/index.php?op=perm');
    $perm_form->addItem(1, _AM_ACHAT_PERM_CANPOST, 0);

    echo $perm_form->render();

    include_once './admin_footer.php';
}

$op = 'main';
if ( !isset($_POST['op']) ) {
    $op = isset( $_GET['op'] ) ? $_GET['op'] : 'main';
} else {
    $op = $_POST['op'];
}


switch ( $op ) {
    case 'purge':
        purge();
        break;
    case 'purge2':
        purge2();
        break;
    case 'deletemsg':
        deletemsg();
        break;
    case 'perm':
        perm();
        break;
    case 'main':
    default:
        achat();
        break;
}
?>
