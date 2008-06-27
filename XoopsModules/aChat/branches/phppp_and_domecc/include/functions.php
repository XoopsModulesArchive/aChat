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
// v 0.2 2006/08/18 17:11:37
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
 * Returns the last color used by the member
 *
 * @author Niluge_KiWi
 * @copyright	(c) The Xoops Project - www.xoops.org
 */
function aChat_Get_Last_Color()
{	
	global $xoopsDB;
	
	$color = '';
	$uid = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar("uid") : false;
	if($uid) {
		$result = $xoopsDB->query( "SELECT color FROM " . $xoopsDB->prefix( "achat_messages" ) . " WHERE uid=$uid ORDER BY date DESC, mid DESC LIMIT 1" );
		list( $color ) = $xoopsDB->fetchRow( $result );
	}
	return $color;
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
?>