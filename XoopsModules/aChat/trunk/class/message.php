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
// v 0.23 2007/08/13 23:05:37
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
		$this->initVar('mid', XOBJ_DTYPE_INT, null, true);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, true);
		$this->initVar('uname', XOBJ_DTYPE_TXTBOX, null, false, 60);
		$this->initVar('msg', XOBJ_DTYPE_OTHER, null, true, 255);
		$this->initVar('color', XOBJ_DTYPE_TXTBOX, '000000', false);
		$this->initVar('date', XOBJ_DTYPE_INT, null, true);
		$this->initVar('ip', XOBJ_DTYPE_TXTBOX, '0.0.0.0', true, 15);
	}
	
	
	// checkVar
	function checkVar_color(&$value)
	{
		$colors = aChat_Get_Allowed_Colors();

		if (!in_array($value, $colors)) {
            $this->setErrors('bad color posted.');
	        return false;
		}
		return true;
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
		return new achatMessage();
	}

	

	/**
	 * Insert message in database
	 * 
	 * 
	 * @return	bool   if message is inserted : TRUE
	 */
	function insert($msgobj)
	{	
		// Message vierge pour récupérer les valeurs par défaut si les checkVars retournent false
		$emptymsgobj =& $this->create();
		
		// Gestion des checkVar avant insertion
		foreach ($msgobj->vars as $k => $v) {
			${$k} = $v['value'];
			$checkMethod = 'checkVar_'.$k;
			if(method_exists($msgobj, $checkMethod)) {
				${$k} = $msgobj->$checkMethod(${$k}) ? ${$k} : $emptymsgobj->getVar($k);
			}
		}

		$sql = "INSERT INTO ".$this->db->prefix("achat_messages")." (uid, uname, msg, color, date, ip) VALUES ('$uid', '$uname', '$msg', '$color', '$date', '$ip')";

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
			$order = !empty($order) ? ' ORDER BY mid '.$order : '';
			$sql .= ' '.$criteria->renderWhere().$order;
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
	function getMessagesForDisplay($ret, $array = true)
	{	
		global $xoopsUser;
		$myts = &MyTextSanitizer::getInstance();
		
		// Configuration de l'affichage des messages
		$html = 0;
		$smiley = getmoduleoptionNK('use_smilies');
		$bbcodes = getmoduleoptionNK('use_bbcodes');
			
		$ret2 = array();
		// Boucle de traitement des variables pour l'affichage.
		foreach ($ret as $msgobj) {
			$uname = $msgobj->getVar('uname');
			if( empty($uname) ) {
				$msgobj->setVar('uname', XoopsUser::getUnameFromId($msgobj->getVar('uid')));
			}
			$msgobj->setVar('msg', $myts->displayTarea($msgobj->getVar('msg'),$html,$smiley,$bbcodes));
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
    function MsgstoArray($msgobjs) {
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
	 * DB update procedure
	 * @return bool
	 */
	function processPostRequest()
	{
		$message = isset($_POST['achat_input']) ? aChat_utf8RawUrlDecode($_POST['achat_input']) : '';
		// Si le message est vide, on arrete.
		if($message == '') {
			return false;
		}
		$myts =& MyTextSanitizer::getInstance();
		
		// Gestion du message
		$message = $myts->addSlashes($message);
		$message = $myts->htmlSpecialChars($myts->stripSlashesGPC($message));
		$message = $myts->censorString($message);
		// Gestion anti répétition
		$lastmsgobj = $this->getLastPost();
		$lastmsg = $lastmsgobj->getVar('msg');
		if(($lastmsg == $message) && ($lastmsgobj->getVar('date')>(time()-300))) {
			return false;
		}
		
		// Gestion de l'uid
		$uid = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar("uid") : 0;
		
		// Gestion du pseudo
		$uname = '';
		if($uid == 0 && isset($_POST['achat_uname'])) {
			$uname = $myts->htmlSpecialChars($myts->stripSlashesGPC(substr(aChat_utf8RawUrlDecode($_POST['achat_uname']),0,15)));
		}
		
		// Gestion de la couleur
		$color = isset($_POST["color"]) ? $_POST["color"] : "000000";
		
		// Gestion de l'ip du posteur
		$ip = aChat_Get_Ip();
		
		// Objet message
		$msgobj =& $this->create();
		$msgobj->setVar('uid', $uid);
		$msgobj->setVar('uname', $uname);
		$msgobj->setVar('msg', $message);
		$msgobj->setVar('color', $color);
		$msgobj->setVar('date', time());
		$msgobj->setVar('ip', $ip);
		$msgobj->cleanVars();
		return $this->insert($msgobj);
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
		$html = 0;
		$smiley = getmoduleoptionNK('use_smilies');
		$bbcodes = getmoduleoptionNK('use_bbcodes');
		
		if($op == 'from') {
			$result = $this->db -> query( "SELECT * FROM " . $this->db -> prefix( "achat_messages" ) . " WHERE mid > " . $n . " ORDER BY mid DESC" );
		} else {
			$result = $this->db -> query( "SELECT * FROM " . $this->db -> prefix( "achat_messages" ) . " ORDER BY mid DESC", $n );
		}
				
		$sortie = array();
		// Boucle de traitement des variables pour l'affichage.
		while ($myrow = $this->db->fetchArray($result)) {
			$myrow['uname'] = empty($myrow['uname']) ? XoopsUser::getUnameFromId($myrow['uid']) : $myrow['uname'];
			$myrow['msg'] =  $myts->displayTarea($myrow['msg'],$html,$smiley,$bbcodes);
			$myrow['date'] = formatTimestamp($myrow['date']);
			$sortie[] = $myrow;
		}
		
		return array_reverse($sortie);
	}
	
	/**
	 * Récupère le dernier message posté par le visiteur
	 * 
	 * @param	integer $uid, string $ip
	 * 
	 * @return	aChatMessage object
	 */
	function getLastPost($uid = -1, $ip = null)
	{
		global $xoopsUser;
		if($uid == -1) {
			$uid = is_object($xoopsUser) ? $xoopsUser->getVar("uid") : 0;
			$ip = aChat_Get_Ip();
		}
		$msgobj = $this->create();

		$moresql = ($uid == 0) ? " AND ip = '". $ip ."' AND date > ".(time()-86400) : '';
		$sql = 'SELECT * FROM '. $this->db -> prefix( "achat_messages" ) .' WHERE uid = '. $uid . $moresql .' ORDER BY mid DESC LIMIT 1';
		$result =& $this->db->query($sql);
		
		
		$myrow = $this->db->fetchArray($result);
		if(!$myrow){
			return $msgobj;
		}
		$msgobj->assignVars($myrow);
		
		return $msgobj;
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
			$sql .= ' '.$criteria->renderWhere().' ORDER BY mid '.$order;
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		return $this->db->query($sql, $limit, $start);
	}
}
?>