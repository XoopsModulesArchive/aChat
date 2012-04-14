<?php
// $Id: functions.php, see below
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
// v 0.232 2007/10/30 13:58:32
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//

/**
 * Returns the allowed colors for messages
 *
 * @author Niluge_KiWi
 * @copyright	(c) The Xoops Project - www.xoops.org
 */
function aChat_Get_Allowed_Colors()
{
    $allowed_colors = getmoduleoptionNK('allowed_colors');

    $colors = (count($allowed_colors) == 1 && $allowed_colors[0] == '') ? array( "000000", "dc0000", "4cb5e8", "6600cc", "336600", "000099", "ff6600", "660000" ) : $allowed_colors;

    return $colors;
}

/**
 * Returns the ip of the member
 *
 * @author Niluge_KiWi
 * @copyright	(c) The Xoops Project - www.xoops.org
 */
function aChat_Get_Ip()
{
    global $_SERVER;
    if($_SERVER) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = xoops_getenv('REMOTE_ADDR');
    }
    return $ip;
}


/**
 * Returns the last color used by the member
 *
 * @author Niluge_KiWi
 * @copyright	(c) The Xoops Project - www.xoops.org
 */
function aChat_Get_Last_Color()
{
    global $msgobj_h, $xoopsUser;

    if(!is_object($msgobj_h))
    $msgobj_h =& xoops_getmodulehandler('message','aChat');

    $msgobj = $msgobj_h->getLastPost();

    return $msgobj->getVar('color');
}

/**
 * Returns true if xoops version >= 2.0.14
 *
 * @author Niluge_KiWi
 * @copyright	(c) The Xoops Project - www.xoops.org
 */
function aChat_Get_Xoops_Version()
{
    $xoops_version_int = substr(XOOPS_VERSION, 6, 1);
    $xoops_version_float = substr(XOOPS_VERSION, 8);

    $xoops_version = $xoops_version_int.'.'.str_replace('.', '', $xoops_version_float);
    return $xoops_version >= 2.014;

}

/**
 * Returns like unescape javascript function, to allow 2 bytes characters
 *
 * @From http://pure-essence.net/stuff/code/utf8RawUrlDecode.phps
 */

function aChat_utf8RawUrlDecode ($source) {
    $decodedStr = "";
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                $decodedStr .= utf8_encode ($entity);
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        } else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    return $decodedStr;
}

/**
 * Returns a module's option
 *
 * Return's a module's option (for the aChat module)
 *
 * @ From package News
 * @author Hervé Thouzard (www.herve-thouzard.com)
 *		Modified by Niluge_KiWi : évite les conflits si différents modules ont des options en commun (même nom)
 * @copyright	(c) The Xoops Project - www.xoops.org
 * @param string $option	module option's name
 */
function getmoduleoptionNK($option, $repmodule='aChat')
{
    global $xoopsModuleConfig, $xoopsModule;
    static $tbloptions= Array(Array());
    if(is_array($tbloptions) && array_key_exists($repmodule,$tbloptions) && array_key_exists($option,$tbloptions[$repmodule])) {
        return $tbloptions[$repmodule][$option];
    }

    $retval=false;
    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if(isset($xoopsModuleConfig[$option])) {
            $retval= $xoopsModuleConfig[$option];
        }
    } else {
        $module_handler =& xoops_gethandler('module');
        $module =& $module_handler->getByDirname($repmodule);
        $config_handler =& xoops_gethandler('config');
        if ($module) {
            $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
            if(isset($moduleConfig[$option])) {
                $retval= $moduleConfig[$option];
            }
        }
    }
    $tbloptions[$repmodule][$option]=$retval;
    return $retval;
}

// Gestion des headers (javascript et css)
function aChat_JS_CSS_Headers($tmp_refresh = 15) {
    global $xoTheme, $xoopsTpl;
     
    $aChat_url = XOOPS_URL.'/modules/aChat/';
    if(isset($xoTheme) && is_object($xoTheme)) {

        $xoTheme->addScript( '', array( 'type' => 'text/javascript' ), '	var aChat_url = "' .XOOPS_URL.'/modules/aChat";
   	var aChat_tmp_refresh = '.$tmp_refresh.';' );
        $xoTheme->addScript( $aChat_url.'/include/js/XHRConnection.js' );
        $xoTheme->addScript( $aChat_url.'/include/js/aChat_functions.js' );
        $xoTheme->addStylesheet( $aChat_url.'/templates/aChat.css' );

    } elseif(isset($xoopsTpl) && is_object($xoopsTpl)) {	// Compatibilité avec les anciennes versions de Xoops
         
        $achat_module_header = '   <link rel="stylesheet" type="text/css" href="'.$aChat_url.'/templates/aChat.css" />
   <script type="text/javascript">
   	var aChat_url = "' .XOOPS_URL.'/modules/aChat";
   	var aChat_tmp_refresh = '.$tmp_refresh.';
   </script>
   <script src="'.$aChat_url.'/include/js/XHRConnection.js" type="text/javascript"></script>
   <script src="'.$aChat_url.'/include/js/aChat_functions.js" type="text/javascript"></script>';
        $xoopsTpl->assign('xoops_module_header', $achat_module_header);
    }
}

?>
