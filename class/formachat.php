<?php
// $Id: formachat.php, see below
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
// v 0.2 2006/08/30 19:30:18
// ======================================================================== //
//
//   www.lmdmf.net
//
// kiwiiii@gmail.com
//
// ======================================================================== //
//
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

/**
 * A aChat form :
 * 
 * aChat
 */
	class XoopsFormaChat extends XoopsFormText {
	
	function XoopsFormaChat($size=50, $value="")
	{
		$this->XoopsFormText('', 'achat_input', $size, 255, $value);
	}
	
	/**
	 * Prepare HTML for output
	 * 
     * @return	string  HTML
	 */
	function render(){

		$ret = $this->_renderUname_Input();
		$enterkey = ''; 
		if(!empty($ret)) {
			$enterkey = ' onKeyPress="submitenter(event)"';
		}
		$ret .= '<input type="text" name="'.$this->getName().'" id="'.$this->getName().'" size="'.$this->getSize().'" maxlength="'.$this->getMaxlength().'" value="'.$this->getValue().'"'.$enterkey.' accesskey="N" />';
		$ret .= '<input class="formButton" name="achat_submit" id="achat_submit" value="'._MD_ACHAT_SENDMSG.'" type="button" onclick="achat_checkinput();">';
		$ret .= '&nbsp;&nbsp;<a href="javascript:;" onclick="changeAffichage(\'achat_options_box\');">'. _OPTIONS .'</a><br /><div id="achat_options_box" style="display: none;">';
		$ret .= $this->_renderSmileys();
		$ret .= $this->_renderColor_Box();
		$ret .= '</div>';
		return $ret;
	}

	
	/**
	 * prepare HTML for output of the smiley list.
     *
	 * @return	string HTML
	 * taken from     formdhtmltextarea.php,v 1.13.24.1 2005/08/15 15:04:58 skalpa Exp
	 */
	function _renderSmileys()
	{
		$myts =& MyTextSanitizer::getInstance();
		$smiles =& $myts->getSmileys();
		$ret = '';
		if (empty($smileys)) {
			$db =& Database::getInstance();
			if ($result = $db->query('SELECT * FROM '.$db->prefix('smiles').' WHERE display=1')) {
				while ($smiles = $db->fetchArray($result)) {
					$ret .= "<img onclick='xoopsCodeSmilie(\"".$this->getName()."\", \" ".$smiles['code']." \");' onmouseover='style.cursor=\"hand\"' src='".XOOPS_UPLOAD_URL."/".htmlspecialchars($smiles['smile_url'], ENT_QUOTES)."' alt='' />";
				}
			}
		} else {
			$count = count($smiles);
			for ($i = 0; $i < $count; $i++) {
				if ($smiles[$i]['display'] == 1) {
					$ret .= "<img onclick='xoopsCodeSmilie(\"".$this->getName()."\", \" ".$smiles[$i]['code']." \");' onmouseover='style.cursor=\"hand\"' src='".XOOPS_UPLOAD_URL."/".$myts->oopsHtmlSpecialChars($smiles['smile_url'])."' border='0' alt='' />";
				}
			}
		}
		$ret .= "&nbsp;[<a href='#moresmiley' onclick='javascript:openWithSelfMain(\"".XOOPS_URL."/misc.php?action=showpopups&amp;type=smilies&amp;target=".$this->getName()."\",\"smilies\",300,475);'>"._MORE."</a>]";
		return $ret;
	}
	
	/**
	 * prepare HTML for output of the Color Box.
     *
	 * @return	string HTML
	 * taken and modified from discuss module
	 */
	
	function _renderColor_Box() {
		
		$colors = aChat_Get_Allowed_Colors();
		
		$color_box = '<div id="color_box">';
		
		//$color_used = aChat_Get_Last_Color();
		//$checkedcolor = in_array($color_used, $colors);
		//$color_box .= '<!--'.$checkedcolor ? 'ok' : 'pasok'.'-->';
		
		for($i=0;$i<count($colors);$i++) {
			$j = $i+1;
			//$checked = ( ($checkedcolor && ($colors[$i] == $color_used)) || (!$checkedcolor && ($i == 0)) ) ? ' checked="checked"' : '';
			$checked = ( $i == 0 ) ? ' checked="checked"' : '';
			$color_box .= '	<input id="color'. $j .'" name="color" value="'.$colors[$i].'" type="radio"'.$checked.'>
	<span style="padding: 0px; color: #'.$colors[$i].';">&#9632;</span>';
		}
		$color_box .= '</div>';
		return $color_box;
	}
	
	/**
	 * prepare HTML for output of the Uname input.
     *
	 * @return	string HTML
	 * 
	 */
	
	function _renderUname_Input() {
		global $xoopsUser;
		$ret = '';
		if(!is_object($xoopsUser) && getmoduleoptionNK('nick4guests') == 1) {
			$ret = '<input type="text" name="achat_uname" id="achat_uname" size="6" maxlength="15" value="'.rtrim(_USERNAME, ' :&nbsp;').'" /><br />';
		}
		return $ret;
	}
}
?>