<?php
// $Id: message.php, see below
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
// v 0.2 2006/08/25 16:57:18
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
 * aChat Message class
 * 
 * Inspired from message.php from Discuss module.
 */
 
 
class achatMessage extends XoopsObject {
	
	/**
	 * constructor
	 * @access public
	 */
	function achatMessage()
	{
		// call parent constructor
		$this->XoopsObject();
		
		// define object elements
		$this->initVar('mid', 		XOBJ_DTYPE_INT, null, 		true);
		$this->initVar('uid', 		XOBJ_DTYPE_INT, null, 		true);
		$this->initVar('uname', 	XOBJ_DTYPE_TXTBOX, null, 	false, 60);
		$this->initVar('msg', 		XOBJ_DTYPE_TXTBOX, null, 	true, 255);
		$this->initVar('color', 	XOBJ_DTYPE_TXTBOX, 			'000000', false);
		$this->initVar('date', 		XOBJ_DTYPE_INT, 			null, true);
		$this->initVar('ip', 		XOBJ_DTYPE_TXTBOX, 			'0.0.0.0', true, 15);
	}
	
	
	// checkVar
	function checkVar_color($value)
	{
		$colors = aChat_Get_Allowed_Colors();

		if (!in_array($value, $colors)) {
            $this->setErrors('bad color posted.');
	        return '000000';
		}
		return $value;
	}

}

class achatMessageHandler extends XoopsObjectHandler 
{
	/**
	 * constructor
	 * @param object $db reference to the {@link XoopsDatabase} object
	 */
	function achatMessageHandler($db) 
	{
		// call parent constructor
		$this->XoopsObjectHandler($db);
	}
	
	function &create()
	{
		$ret =& new achatMessage();
		return $ret;
	}	

	/**
	 * Insert message in database
	 * 
	 * 
	 * @return	bool   if message is inserted : TRUE
	 */
	function insert(&$msgobj)
	{	
		$msgobj->cleanVars();
		// Gestion des checkVar avant insertion
		foreach ($msgobj->cleanVars as $k => $v) {
			${$k} = $v;
			if($k == "color"){
				${$k} = $msgobj->checkVar_color(${$k});
			}
		}

		$sql = "INSERT INTO ".$this->db->prefix("achat_messages")." (uid, uname, msg, color, date, ip) VALUES ('$uid', ".$this->db->quoteString($uname).", ".$this->db->quoteString($msg).", ".$this->db->quoteString($color).", '$date', ".$this->db->quoteString($ip).")";
		return $this->db->queryF($sql);
	}
	
	/**
     * Get some {@link achatMessage}s 
     * 
     * @param	object  $criteria   {@link CriteriaElement} 
     * @param	bool    $id_as_key  Use the IDs as array-keys?
     * 
     * @return	array   Array of {@link achatMessage}s 
     */
	function &getObjects($criteria = null, $id_as_key = false)
    {
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('achat_messages');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$order = $criteria->getOrder();
			$order = empty($order) ? 'DESC' : $order;
			$sql .= ' '.$criteria->renderWhere().' ORDER BY date '.$order.', mid '.$order;
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$msgobj = $this->create();
			$msgobj->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $msgobj;
			} else {
				$ret[$myrow['mid']] =& $msgobj;
			}
			unset($msgobj);
		}
		return $ret;
	}
	
	/**
     * Clear messages for display
     * 
     * @param	array   Array of {@link achatMessage}s 
     * 
     * @return	array   Array of {@link achatMessage}s 
     */
	function getMessagesForDisplay(&$ret, $array = true)
	{	
		global $xoopsUser;
		$myts = &MyTextSanitizer::getInstance();
		
		// Configuration de l'affichage des messages
		$dohtml = 0;
		$dosmiley = getmoduleoptionNK('use_smilies');
		$doxcode = getmoduleoptionNK('use_bbcodes');
		$doimage = 0;
		$dobr = 0;
			
		$ret2 = array();
		// Boucle de traitement des variables pour l'affichage.
		foreach ($ret as $msgobj) {
			$uname = $msgobj->getVar('uname');
			if( empty($uname) ) {
				$msgobj->setVar('uname', XoopsUser::getUnameFromId($msgobj->getVar('uid')));
			}
			$msg = $msgobj->getVar('msg', 'n');
			$msgobj->setVar('msg', $myts->displayTarea($msg, $dohtml, $dosmiley, $doxcode, $doimage, $dobr));
			$msgobj->setVar('date', formatTimestamp($msgobj->getVar('date')));
			$ret2[] = $msgobj;
		}
		
		if($array) {
			return $this->MsgstoArray($ret2);
		} else {
			return $ret2;
		}
	}
	
	/**
     * Returns an array representation of the object
     *
	 * From xoops 2.2
     * @return array
     */
    function MsgstoArray(&$msgobjs) {
		$ret = array();
		foreach ($msgobjs as $msgobj) {
			$msg = array();
			$vars = $msgobj->getVars();
			foreach (array_keys($vars) as $i) {
				$msg[$i] = $msgobj->getVar($i);
			}
			$ret[] = $msg;
			unset($msg);
		}
        return $ret;
    }
	
	/**
	 * From xoopstableobject class
	 * 
	 * @param	object	$criteria 
	 * 
	 * @return	integer
	 */
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '. $this->db -> prefix( "achat_messages" );
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		$result =& $this->db->query($sql);
		if (!$result) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}
	
	/**
	 * unicode to normal coding
	 *
	 * D.J.
	 * TODO: charset encoding conversion
	 */
	function unicode_decode($input)
	{
	   $output = $input;
	   if(!preg_match_all('/%u([[:alnum:]]{4})/', $input, $matches)) return $output;
	 
	   foreach ($matches[1] as $uniord)
	   {
	       $utf = '&#x' . $uniord . ';';
	       $output = str_replace('%u'.$uniord, $utf, $output);
	   }
	 
	   $output = urldecode($output);
	   return $output;
	}
	
	/**
	 * DB update procedure
	 * @return bool
	 */
	function processPostRequest()
	{
		$message = isset($_POST['achat_input']) ? $_POST['achat_input'] : '';
		// Si le message est non vide, on l'insert.
		if($message != '') {
			$myts =& MyTextSanitizer::getInstance();
			
			// Gestion de l'uid
			$uid = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar("uid") : 0;
			
			// Gestion du pseudo
			$uname = '';
			if($uid == 0 && isset($_POST['achat_uname'])) {
				//$uname = $myts->htmlSpecialChars($myts->stripSlashesGPC(substr($_POST['achat_uname'],0,15)));
				$uname = $_POST['achat_uname'];
			}
			
			// Gestion du message
			//$message = $myts->addSlashes($message);
			//$message = $myts->htmlSpecialChars($myts->stripSlashesGPC($message));
			$message = $this->unicode_decode($message);
			$message = $myts->censorString($message);
	
			// Gestion de la couleur
			$color = isset($_POST["color"]) ? $_POST["color"] : "000000";
			
			// Gestion de l'ip du posteur
			global $_SERVER;
			if($_SERVER) {
				$ip = $_SERVER['REMOTE_ADDR'];
			} else {
				$ip = xoops_getenv('REMOTE_ADDR');
			}
			
			// Objet message
			$msgobj =& $this->create();
			$msgobj->setVar('uid', $uid);
			$msgobj->setVar('uname', $uname);
			$msgobj->setVar('msg', $message);
			$msgobj->setVar('color', $color);
			$msgobj->setVar('date', time());
			$msgobj->setVar('ip', $ip);
			//$msgobj->cleanVars();
			return $this->insert($msgobj);
		}
		return false;
	}
	
	/**
	 * get message-array
	 * @return array $messages(array('mid'=>,'uname'=>,'message'=>,'color'=>))
	 */
	 
	function &getMessages($op, $n)
	{	
		global $xoopsUser;
		$myts = &MyTextSanitizer::getInstance();
		
		// Configuration de l'affichage des messages
		$dohtml = 0;
		$dosmiley = getmoduleoptionNK('use_smilies');
		$doxcode = getmoduleoptionNK('use_bbcodes');
		$doimage = 0;
		$dobr = 0;
		
		$n = intval($n);
		if($op == 'from') {
			$result = $this->db -> query( "SELECT * FROM " . $this->db -> prefix( "achat_messages" ) . " WHERE `mid` > " . $n . " ORDER BY `mid` DESC" );
		} else {
			$result = $this->db -> query( "SELECT * FROM " . $this->db -> prefix( "achat_messages" ) . " ORDER BY `mid` DESC", $n );
		}
				
		$sortie = array();
		$uid = array();
		while ($myrow = $this->db->fetchArray($result)) {
			if(empty($myrow['uname'])){
				$uid[$myrow['uid']] = 1;
				$myrow['uname'] = "";
			}else{
				$myrow['uname'] =$myts->htmlspecialchars($myrow['uname']);
			}
			$myrow['msg'] =  $myts->displayTarea($myrow['msg'], $dohtml, $dosmiley, $doxcode, $doimage, $dobr);
			$myrow['date'] = formatTimestamp($myrow['date']);
			$sortie[] = $myrow;
		}
		$ret = array();
		if(@include_once XOOPS_ROOT_PATH."/Frameworks/art/functions.user.php"){
			$usernames = mod_getUnameFromIds(array_keys($uid));
			foreach($sortie as $key => $data){
				if(empty($data["uname"]) && isset($usernames[$data["uid"]])){
					$data["uname"] = $usernames[$data["uid"]];
				}
				$ret[] = $data;
			}
		}
		unset($sortie);
		$ret = array_reverse($ret);
		return $ret;
	}
	
	
	// Fonctions administration :
	// Pas utilisées...
	
	/**
     * Del some {@link achatMessage}s 
     * 
     * @param	object  $criteria   {@link CriteriaElement} 
     * @param	bool    $id_as_key  Use the IDs as array-keys?
     * 
     * @return	bool
     */
	function &DelObjects($criteria = null, $id_as_key = false)
    {
		$limit = $start = 0;
		$sql = 'DELETE FROM '.$this->db->prefix('achat_messages');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$order = $criteria->getOrder();
			$order = empty($order) ? 'DESC' : $order;
			$sql .= ' '.$criteria->renderWhere().' ORDER BY date '.$order.', mid '.$order;
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		return $this->db->query($sql, $limit, $start);
	}
}
?>