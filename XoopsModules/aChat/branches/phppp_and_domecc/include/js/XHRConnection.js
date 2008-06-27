// + --------------------------------------------------------------------------------------
// + XHRConnection
// + V1.3
// + Thanh Nguyen, http://www.sutekidane.net
// + 20.10.2005
// + http://creativecommons.org/licenses/by-nc-sa/2.0/fr/deed.fr
// + --------------------------------------------------------------------------------------
function XHRConnection() {
	
	// + ----------------------------------------------------------------------------------
	var conn = false;
	var debug = false;
	var datas = new String();
	var areaId = new String();
	// Objet XML
	var xmlObj;
	// Type de comportement au chargement du XML
	var xmlLoad;
	
	// + ----------------------------------------------------------------------------------
	try {
		conn = new XMLHttpRequest();		
	}
	catch (error) {
		if (debug) { alert('Erreur lors de la tentative de cration de l\'objet \nnew XMLHttpRequest()\n\n' + error); }
		try {
			conn = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (error) {
			if (debug) { alert('Erreur lors de la tentative de cration de l\'objet \nnew ActiveXObject("Microsoft.XMLHTTP")\n\n' + error); }
			try {
				conn = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (error) {
				if (debug) { alert('Erreur lors de la tentative de cration de l\'objet \nnew ActiveXObject("Msxml2.XMLHTTP")\n\n' + error); }
				conn = false;
			}
		}
	}

	// + ----------------------------------------------------------------------------------
	// + setDebugOff
	// + Dsactive l'affichage des exceptions
	// + ----------------------------------------------------------------------------------
	this.setDebugOff = function() {
		debug = false;
	};

	// + ----------------------------------------------------------------------------------
	// + setDebugOn
	// + Active l'affichage des exceptions
	// + ----------------------------------------------------------------------------------
	this.setDebugOn = function() {
		debug = true;
	};
	
	// + ----------------------------------------------------------------------------------
	// + resetData
	// + Permet de vider la pile des donnes
	// + ----------------------------------------------------------------------------------
	this.resetData = function() {
		datas = new String();
		datas = '';
	};
	
	// + ----------------------------------------------------------------------------------
	// + appendData
	// + Permet d'empiler des donnes afin de les envoyer
	// + ----------------------------------------------------------------------------------
	this.appendData = function(pfield, pvalue) {
		datas += (datas.length == 0) ? pfield+ "=" + escape(pvalue) : "&" + pfield + "=" + escape(pvalue);
	};
	
	// + ----------------------------------------------------------------------------------
	// + setRefreshArea
	// + Indique quel elment identifi par id est valoris lorsque l'objet XHR reoit une rponse
	// + ----------------------------------------------------------------------------------
	this.setRefreshArea = function(id) {
		areaId = id;
	};
	
	// + ----------------------------------------------------------------------------------
	// + createXMLObject
	// + Mthode permettant de crer un objet DOM, retourne la rfrence
	// + Inspir de: http://www.quirksmode.org/dom/importxml.html
	// + ----------------------------------------------------------------------------------
	this.createXMLObject = function() {
		try {
			 	xmlDoc = document.implementation.createDocument("", "", null);
				xmlLoad = 'onload';
		}
		catch (error) {
			try {
				xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
				xmlLoad = 'onreadystatechange ';
			}
			catch (error) {
				if (debug) { alert('Erreur lors de la tentative de cration de l\'objet XML\n\n'); }
				return false;
			}
		}
		return xmlDoc;
	}
	
	// + ----------------------------------------------------------------------------------
	// + Permet de dfinir l'objet XML qui doit tre valoris lorsque l'objet XHR reoit une rponse
	// + ----------------------------------------------------------------------------------
	this.setXMLObject = function(obj) {
		if (obj == undefined) {
				if (debug) { alert('Paramtre manquant lors de l\'appel de la mthode setXMLObject'); }
				return false;
		}
		try {
			//xmlObj = this.createXMLObject();
			xmlObj = obj;
		}
		catch (error) {
				if (debug) { alert('Erreur lors de l\'affectation de l\'objet XML dans la mthode setXMLObject'); }
		}
	}
	
	// + ----------------------------------------------------------------------------------
	// + loadXML
	// + Charge un fichier XML
	// + Entres
	// + 	xml			String		Le fichier XML  charger
	// + ----------------------------------------------------------------------------------
	this.loadXML = function(xml, callBack) {
		if (!conn) return false;
		// Chargement pour alimenter un objet DOM
		if (xmlObj && xml) {
			if (typeof callBack == "function") {
				if (xmlLoad == 'onload') {
					xmlObj.onload = function() {
						callBack(xmlObj);
					}
				}
				else {
					xmlObj.onreadystatechange = function() {
						if (xmlObj.readyState == 4) callBack(xmlObj)
					}
				}
			}
			xmlObj.load(xml);
			return;
		}		
	}

	// + ----------------------------------------------------------------------------------
	// + sendAndLoad
	// + Connexion  la page dsire avec envoie des donnes, puis mise en attente de la rponse
	// + Entres
	// + 	Url			String		L'url de la page  laquelle l'objet doit se connecter
	// + 	httpMode		String		La mthode de communication HTTP : GET, HEAD ou POST
	// + 	callBack		Objet		Le nom de la fonction de callback
	// + ----------------------------------------------------------------------------------
	this.sendAndLoad = function(Url, httpMode, callBack, add) {
		httpMode = httpMode.toUpperCase();
		conn.onreadystatechange = function() {
			if (conn.readyState == 4 && conn.status == 200) {
				// Si une zone destine  rcuprer le rsultat a t dfinie
				if (areaId.length > 0){
					try {
						//ajout NK : possibilit d'ajouter au lieu de remplacer
						// et antiflood bug
						// et scroll auto
						if (add) document.getElementById(areaId).innerHTML += conn.responseText;
						else document.getElementById(areaId).innerHTML = conn.responseText;
						if(achat_show_messages()) {
							scrollDown();
						}
					}
					catch(error) {
						if (debug) { alert('Echec, ' + areaId + ' n\'est pas un objet valide'); }
					}
					return;
				}
				// Si une fonction de callBack a t dfinie
				if (typeof callBack == "function") {
					callBack(conn);
					return;
				}
			}
		};
		switch(httpMode) {
			case "GET":
				try {
					Url = (datas.length > 0) ? Url + "?" + datas : Url;
					conn.open("GET", Url);
					conn.send(null);
				}
				catch(error) {
					if (debug) { alert('Echec lors de la transaction avec ' + Url + ' via la mthode GET'); }
					return false;
				}
			break;
			case "POST":
				try {
					conn.open("POST", Url); 
					conn.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					conn.send(datas);
				}
				catch(error) {
					if (debug) { alert('Echec lors de la transaction avec ' + Url + ' via la mthode POST'); }
					return false;
				}
			break;
			default :
				return false;
			break;
		}
		return true;
	};
	return this;
}