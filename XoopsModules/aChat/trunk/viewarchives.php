<?php
// $Id: viewarchives.php, see below
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
// v 0.23 2007/10/12 22:38:22
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
include "./header.php";
include XOOPS_ROOT_PATH.'/header.php';

$from = !empty($_GET['from']) ? intval($_GET['from']) : 0;
$to = isset($_GET['to']) ? intval($_GET['to']) : 0;

$purge_folder = rtrim (ltrim(getmoduleoptionNK('purge_folder'), '/'), '/');
$rep = empty($purge_folder) ? XOOPS_ROOT_PATH.'/modules/aChat/logs' : XOOPS_ROOT_PATH.'/'.$purge_folder;

function archives_home($rep)
{
    echo '<div style="text-align:center;">
	<h1>'._MD_ACHAT_TITLE.'</h2>
	<h3>'._MD_ACHAT_TITLE_ARCHIVES.'</h3>
</div><br />';

    $rep = opendir($rep);
    $AuMoinsUnLog = false;
    echo '<ul>';
    while ($file = readdir($rep)){
        if($file != '..' && $file !='.' && $file !=''){
            if (!is_dir($file) && preg_match('/aChat_logs\_\-\_([0-9]*)\_to\_([0-9]*)\.html/',$file, $results)){
                $AuMoinsUnLog = true;
                echo '<li><a href="'.XOOPS_URL.'/modules/aChat/viewarchives.php?from='.$results[1].'&to='.$results[2].'">'._MD_ACHAT_MESSAGES .' '. _MD_ACHAT_ARCHIVE_FROM .' '.formatTimestamp($results[1]).' '. _MD_ACHAT_ARCHIVE_TO .' '.formatTimestamp($results[2]).'</a></li>';
            }
        }
    }
    if(!$AuMoinsUnLog) {
        echo '<li>'._MD_ACHAT_ARCHIVE_NO.'</li>';
    }
    echo '<ul>';
}

function archive_read($from, $to, $rep)
{
    $file = 'aChat_logs_-_'. $from .'_to_'. $to .'.html';
    $filename = $rep.'/'.$file;

    echo '<a href="'.XOOPS_URL.'/modules/aChat/viewarchives.php">'. _MD_ACHAT_ARCHIVE_RETURN . '</a><hr /><br />';

    if(file_exists($filename)) {
        include($filename);
    } else {
        echo _MD_ACHAT_ARCHIVE_NOARCHIVESELECTED;
    }

    echo '<br /><hr /><a href="'.XOOPS_URL.'/modules/aChat/viewarchives.php">'. _MD_ACHAT_ARCHIVE_RETURN . '</a>';
}
switch($from) {
    case 0 :
        archives_home($rep);
        break;

    default :
        archive_read($from, $to, $rep);
        break;
}
include(XOOPS_ROOT_PATH."/footer.php");
?>
