// + --------------------------------------------------------------------------------------
// +  JavaScript functions for aChat
// +  v0.2  26.08.2006  22:54:13
// +  By Niluge_KiWi
// +  kiwiiii@gmail.com
// +  With XHRConnection v1.3
// + --------------------------------------------------------------------------------------

window.onload = achat_init;

// initialisation compteur d'envoi et tableau pour controler les refresh
var compteur = 0;
var tableau_refresh = new Array('true','false');

function achat_init() {
	var objForm = xoopsGetElementById('achatform');

	// Gestion du form d'envoie si il n'existe pas (si le visiteur n'a pas le droit de poster
	try {
		//Supprimez les // ci-dessous pour activer l'autofocus
		//objForm.achat_input.focus();
	}
	catch(error) {}

	scrollDown();
	
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
	achat_refresh(0);
}

function achat_send() {
	
	var objForm = xoopsGetElementById('achatform');
	
	var XHR = new XHRConnection();
	
	// Si le navigateur ne gère pas AJAX, on valide le post normalement
	if(!XHR) {
		objForm.submit();
	} else {
	XHR.resetData();
	
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
	
	XHR.setRefreshArea('achat_div_temp');
	XHR.appendData('achat_lastmid', achat_getlastmid());
	XHR.appendData('achat_ajax_submit',1);
	// Et on envoie le tout!
	XHR.sendAndLoad(aChat_url+'/index.php', 'POST',chargefini_send());
	}
}

function achat_refresh(compteur) {
	var XHR = new XHRConnection();
	// Si le navigateur ne gère pas AJAX, on ne refresh pas...(c'est pas top mais bon)
	if(!XHR) {}
	else if(tableau_refresh[compteur]) {
		
		XHR.resetData();

		XHR.setRefreshArea('achat_div_temp');
		
		XHR.appendData('achat_ajax_refresh',1);
		XHR.appendData('achat_lastmid', achat_getlastmid());

		XHR.sendAndLoad(aChat_url+'/index.php', 'POST', setTimeout('achat_refresh('+compteur+')', aChat_tmp_refresh*1000));
	}
}

function achat_getlastmid() {
	var objMessages = xoopsGetElementById('achat_messages');
	if(!achat_isnotempty(objMessages)) {return 0};
	var lastid = 0;
	for (var i=0;i<objMessages.childNodes.length;i++) {
		if (objMessages.childNodes[i].nodeName == "DIV") {
			lastid = i;
		}
	}
	return objMessages.childNodes[lastid].getAttribute('id').substr(7);
}

function achat_isnotempty(obj) {
	for (var i=0;i<obj.childNodes.length;i++) {
		if (obj.childNodes[i].nodeName == "DIV") {
			return true;
		}
	}
	return false;
}
function achat_show_messages() {
	// fonction qui évite des bug flood, enregardant si la div affichée existe déjà, si oui elle est supprimée de la div temporaire
	var objTemp = xoopsGetElementById('achat_div_temp');
	// Si il y a des nouveaux messages
	if(achat_isnotempty(objTemp)) {
		var objMessages = xoopsGetElementById('achat_messages');
		var lastmid = achat_getlastmid();
		//alert('lastmid'+lastmid);
		for (var i=0;i<objTemp.childNodes.length;i++) {
			if (objTemp.childNodes[i].nodeName == 'DIV') {
				var mid = objTemp.childNodes[i].getAttribute('id').substr(7);
				//alert(mid);
				if (mid<=lastmid) {
					//alert('effacé');
					objTemp.removeChild(string.childNodes[i]);
				} else {
					// Gestion des liens et mots trop long:
					achat_Gestion_URL(objTemp.childNodes[i]);
					/* Tronquage des mots trop long désactivés pour le moment 
						car problème avec le code html des smilies par exemple
					if(block) {
						achat_Gestion_Longs_mots(objTemp.childNodes[i].childNodes[3]);
					}*/
				}
			} 
		}
		
		// Si il y a des messages à afficher, on les affiche et on retourne true
		if (objTemp.innerHTML != '') {
			// Et on ajoute les nv messages sans les bugs de répétition.
			var msgs = objMessages.innerHTML + objTemp.innerHTML;
			objMessages.innerHTML = msgs;
			return true;
		}
		else { return false;}
	}
}

function achat_checkinput() {
	// Fonction qui vérifie que le message envoyé n'est pas vide.
	// Si vide : rien
	// Si non vide : on envoie
	var objForm = xoopsGetElementById('achatform');
	var msg = objForm.achat_input.value;
	if( msg != '' || msg != ' ') {
		achat_send();
	}
}

function chargefini_send() {

	var objForm = xoopsGetElementById('achatform');
	objForm.achat_input.value = '';
	objForm.achat_input.focus();
							   
	tableau_refresh[compteur] = false;
	compteur = 1 - compteur;
	tableau_refresh[compteur] = true;
	
	setTimeout('achat_refresh('+compteur+')', aChat_tmp_refresh*1000);
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
	//obj.scrollTop = obj.offsetHeight;
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