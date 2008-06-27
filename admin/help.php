<?php
/** From
* Module: myHome
* Licence : GPL
* Authors :
*           - solo (http://www.wolfpackclan.com)
*/

include_once( "admin_header.php" );
$myts =& MyTextSanitizer::getInstance();

xoops_cp_header();
aChat_adminmenu(_MI_ACHAT_HELP, -1);
OpenTable();
$helpfile = XOOPS_ROOT_PATH . '/modules/aChat/language/' . $xoopsConfig['language'] . '/help.html';
if ( file_exists($helpfile) ) {
	include_once ( $helpfile );
} else {
	include_once ( XOOPS_ROOT_PATH . '/modules/aChat/language/english/help.html' );
}

CloseTable();
include_once( 'admin_footer.php' );
?>