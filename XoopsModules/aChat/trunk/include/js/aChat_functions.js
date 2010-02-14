// + --------------------------------------------------------------------------------------
// +  JavaScript functions for aChat
// +  v0.23  17.08.2007  17:39:13
// +  By Niluge_KiWi
// +  kiwiiii@gmail.com
// +  With XHRConnection v1.3
// + --------------------------------------------------------------------------------------


// + --------------------------------------------------------------------------------------
// + classe pile fifo
// + sur le module de xajax
// + --------------------------------------------------------------------------------------
function achat_pile(size) {

	// + -------------------------------------------------------------------------------
	// + Variables de la pile
	// + -------------------------------------------------------------------------------
	var start = 0;
	var end = 0;
	var commands = [];
	var processing = false;

	// + -------------------------------------------------------------------------------
	// + Ajouter un élément à la pile
	// + -------------------------------------------------------------------------------
	this.push = function(obj) {
		var next = end + 1;
		if (next > size)
			next = 0;
		if (next != start) {				
			commands[end] = obj;
			end = next;
			return true;
		} else { // débordement de pile
			return false;
		}
	}
	
	// + -------------------------------------------------------------------------------
	// + Récupérer le 1er élément de la pile
	// + -------------------------------------------------------------------------------
	this.pop = function() {
		var next = start;
		if (next == end)
			return null;
		next++;
		if (next > size)
			next = 0;
		var obj = commands[start];
		commands[start] = null;
		start = next;
		return obj;
	}
	// + -------------------------------------------------------------------------------
	// + Dépile la pile pour effectuer les requetes
	// + -------------------------------------------------------------------------------
	this.process = function() {
		if(processing) {
			// vide pour l'instant : une boucle est déjà lancée
		} else {
			processing = true;
			var elt = this.pop();
			if(elt == null) {
				// la pile est vide
				processing = false;
				return;
			} else {
				var XHR = elt[0];
				var fonction_fin = elt[1];
				
				XHR.appendData('achat_lastmid', achat_getlastmid());
				// On met à jour la date du dernier refresh
				achat_lrt = new Date();
				
				// Et on envoie le tout!
				XHR.sendAndLoad(aChat_url+'/index.php', 'POST',fonction_fin);
				return;
			}
		}
	}
	// + -------------------------------------------------------------------------------
	// + Change l'état : en cours d'exécution ou non
	// + -------------------------------------------------------------------------------
	this.setProcessingFalse = function() {
		processing = false;
		return true;
	}
	// + -------------------------------------------------------------------------------
	// + Renvoie le nombre d'éléments dans la pile (inutile probablement)
	// + -------------------------------------------------------------------------------
	this.count = function() {
		if(end>start)
			return end-start;
		else
			return size-start+end+1;
	}
	
}


// + --------------------------------------------------------------------------------------
// + Initialisation des scripts et variables
// + --------------------------------------------------------------------------------------
window.onload = achat_init;
// Initialisation du temps : achat_last_refresh_time
var achat_lrt = new Date();
// Initialisation de la variable achat_last_mid
var achat_last_mid = 0;
// Initialisation de la pile des requetes ajax : la taille limite le flood, mais si trop petit avec une connexion internet faible, ca peut poser des problèmes
var laPile_achat = new achat_pile(2);
// Initialisation ping
var achat_ping = 0;


function achat_init() {
	var objForm = xoopsGetElementById('achatform');

	// Gestion du form d'envoie si il n'existe pas (si le visiteur n'a pas le droit de poster
	try {
		//Supprimez les // ci-dessous pour activer l'autofocus
		//objForm.achat_input.focus();
	}
	catch(error) {}

	scrollDown();
	
	achat_getlastmid(true);
	var objMessages = xoopsGetElementById('achat_messages');
	// On tronque les url trop longues
	achat_Gestion_URL(objMessages);
	/* Tronquage des mots trop long désactivés pour le moment 
	car problème avec le code html des smilies par exemple
	// Si bloc : on tronque les mots trop long
	if(block) {
		for (var i=0;i<objMessages.childNodes.length;i++) {
			if (objMessages.childNodes[i].nodeName == 'DIV') {
				achat_Gestion_Longs_mots(objMessages.childNodes[i].childNodes[3]);
			}
		}
	}*/
	// On lance l'auto refresh
	achat_loop_refresh();
}

function achat_loop_pile_process(responseText) {
	// fonction qui affiche le résultat de la requete ajax, puis relance l'exécution de la pile

	// Affiche le ping au refresh(comprend le temps de chargement de xoops...)
	ping = new Date().getTime()-achat_lrt.getTime();
	if(responseText != null) {
		xoopsGetElementById('achat_messages').innerHTML += responseText;
		scrollDown();
	}
	// On met à jour le last mid
	achat_getlastmid(true);
	
	// On relance le process
	laPile_achat.setProcessingFalse();
	laPile_achat.process();
}

function achat_loop_refresh(conn) {
	if(conn != null)
		achat_loop_pile_process(conn.responseText);
	else
		achat_loop_pile_process();
	setTimeout('achat_refresh()', aChat_tmp_refresh*1000);
}

function achat_send() {
	
	var objForm = xoopsGetElementById('achatform');
	
	var XHR = new XHRConnection();
	
	// Si le navigateur ne gère pas AJAX, on valide le post normalement
	if(!XHR) {
		objForm.submit();
	} else {
		
		// Gestion des variables du formulaire 
		// Récupéré sur xajax version 0.2.4, distribué sous GNU
		var formElements = objForm.elements;
		for( var i=0; i < formElements.length; i++)
		{
			if (!formElements[i].name)
				continue;
			if (formElements[i].type && (formElements[i].type == 'radio' || formElements[i].type == 'checkbox') && formElements[i].checked == false)
				continue;
			var name = formElements[i].name;
			if (name)
			{
				if(formElements[i].type=='select-multiple')
				{
					var selectedarray = new Array();
					for (var j = 0; j < formElements[i].length; j++)
					{
						if (formElements[i].options[j].selected == true)
							selectedarray.push(eformElements[i].options[j].value);
					}
					XHR.appendData(name,selectedarray);
				}
				else XHR.appendData(name,formElements[i].value);
			}
		}
			
		// Fin gestion du formulaire
		
		// On vide le champ achat_input
		objForm.achat_input.value = '';

		//XHR.setRefreshArea('achat_messages');
		XHR.appendData('achat_ajax_submit',1);
		
		// On ajoute à la pile d'envoie
		if(!laPile_achat.push([XHR, chargefini_send])) {
			// la pile est pleine : flood ou connexion mauvaise
			//alert("pile pleine");
		}
		// et on lance l'exécution de la pile (si ça n'est pas déjà fait)
		laPile_achat.process();
	}
}

function achat_refresh() {
	var XHR = new XHRConnection();
	// Si le navigateur ne gère pas AJAX, on ne refresh pas...(c'est pas top mais bon)
	if (!XHR) {}
	else if (achat_lrt.getTime() < (new Date().getTime()-aChat_tmp_refresh*1000)) {		
		//XHR.setRefreshArea('achat_messages');
		XHR.appendData('achat_ajax_refresh',1);
		
		// On ajoute à la pile d'envoie
		if(!laPile_achat.push([XHR, achat_loop_refresh])) {
			// la pile est pleine : flood ou connexion mauvaise
			//alert("pile pleine");
			achat_loop_refresh();
		}
		// et on lance l'exécution de la pile (si ça n'est pas déjà fait)
		laPile_achat.process();
		
	} else {
		setTimeout('achat_refresh()', achat_lrt.getTime()+aChat_tmp_refresh*1000-(new Date().getTime()));
	}
}

function achat_is_msgdiv(obj) {
	var est_une_div = (obj.nodeName == "DIV");
	var bon = false;
	var type_fct = typeof obj.getAttribute;
	if(type_fct == "object") {
		// Sous IE7
		bon = obj.getAttribute('id').substr(0,7) == "achat_p";
	} else if(type_fct == "function"){
		// Sous Opera/Firefox
		bon = obj.getAttribute('class') == "achat_dp";
	}
	return est_une_div && bon;
}

function achat_getlastmid(update) {
	if( achat_last_mid == 0 || update ) {
		var objMessages = xoopsGetElementById('achat_messages');
		
		if(!achat_isnotempty(objMessages)) {
			return achat_last_mid;
		}
		
		var lastid = -1;
		var i = objMessages.childNodes.length;
		while (i>0 && lastid<0) {
			i--;
			if (achat_is_msgdiv(objMessages.childNodes[i])) {
				lastid = i;
			}
		}
		if (lastid!=-1)
			achat_last_mid = objMessages.childNodes[lastid].getAttribute('id').substr(7);
	}
	return achat_last_mid;
}

function achat_isnotempty(obj) {
	var i = 0;
	var stop = false;
	while (i<obj.childNodes.length && !stop) {
		if (achat_is_msgdiv(obj.childNodes[i])) {
			stop = true;
		}
		i++;
	}
	return stop;
}

function achat_checkinput() {
	// Fonction qui vérifie que le message envoyé n'est pas vide.
	// Si vide : rien
	// Si non vide : on envoie
	var objForm = xoopsGetElementById('achatform');
	var msg = objForm.achat_input.value;
	
	// Gestion des commandes IRC-Like
	if( msg.substr(0,1) == '/') {
		switch(msg) {
			case "/clear":
				xoopsGetElementById('achat_messages').innerHTML = '';
				objForm.achat_input.value = '';
				return;
			case "/ping":
				xoopsGetElementById('achat_messages').innerHTML += '<div class="achat_div_ping">++ ping: '+ping+'ms ++</div>';
				scrollDown();
				objForm.achat_input.value = '';
				return;
			default : ;
		}
	
	}
	if( msg != '' && msg != ' ') {
		achat_send();
	}
}

function chargefini_send(conn) {

	// On remet le focus sur l'input
	xoopsGetElementById('achatform').achat_input.focus();
	
	// On relance le process
	achat_loop_pile_process(conn.responseText);
}

function changeAffichage(id){
	var elestyle = xoopsGetElementById(id).style;
	if (elestyle.display == "" || elestyle.display == "block") {
		elestyle.display = "none";
	} else {
		elestyle.display = "block";
	}
}

function scrollDown(){
	var obj = xoopsGetElementById('achat_messages');
	obj.scrollTop = obj.scrollHeight - obj.offsetHeight + 20;
}

function achat_Gestion_URL(ObjMsg){
	
	var resultat = ObjMsg.innerHTML.replace( /<a href="(.*?)" target="_blank">(.*?)<\/a>/g, 
			function(str, url, url_title, offset, s) {
				if(url_title.length > 19){
					url_title = url_title.substr(0, 17) + '...';
				}
				return '<a href="'+ url +'" target="_blank">' + url_title + '</a>';
			} );
	
	ObjMsg.innerHTML = resultat;

}

function achat_Gestion_Longs_mots(ObjMsg){
	
	var resultat = ObjMsg.innerHTML.replace( /(\S{20,256})/g, 
			function(str, mot, offset, s) {
				return '<span title="'+ mot +'">' + mot.substr(0, 17) + '...' + '</span>';
				//return  mot.substr(0, 17) + '...' ;
			} );
	
	ObjMsg.innerHTML = resultat;

}

function submitenter(e){

	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13){
	   achat_checkinput();
	   return false;
	  }
	else
	   return true;
}
