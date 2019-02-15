// **
// * @author MadTiago
// * @08.01.2012
// */

function CurrentModule(m) {
	var object = document.getElementById("menu-" + m);
	var classname = object.className;
	var newclass = "current " + classname;
	object.setAttribute("class", newclass);
}

function setStr() {
	var pw = document.getElementById("upass");
	var str_e = document.getElementById("pw_div");
	var v = pw.value;
	var l = v.length;
	if(v == 'Palavra-Passe') {
		str_e.className="pwstr st1";
	}
	if(l < 2) {
		str_e.className="pwstr st1";
	}
	else if(l >= 2 && l <4) {
		str_e.className="pwstr st1";
	}
	else if(l >= 4 && l <6) {
		str_e.className="pwstr st2";
	}
	else if(l >= 6 && l <8) {
		str_e.className="pwstr st3";
	}
	else if(l >= 8) {
		str_e.className="pwstr st4";
	}
}

/* Apagar Boxes */
function ClearBoxesMP() {
	var ob = document.getElementById("onebip");
	var pp = document.getElementById("paypal");
	var psc = document.getElementById("paysafecard");
	var cgd = document.getElementById("transferencia");
	ob.className="mp_box_sprite mp_box";
	pp.className="mp_box_sprite mp_box";
	psc.className="mp_box_sprite mp_box";
	cgd.className="mp_box_sprite mp_box";
}

function ClearBoxesPKS() {
	var p1 = document.getElementById("pack_1");
	var p2 = document.getElementById("pack_2");
	var p3 = document.getElementById("pack_3");
	var p4 = document.getElementById("pack_4");
	p1.className="mp_box_sprite mp_box";
	p2.className="mp_box_sprite mp_box";
	p3.className="mp_box_sprite mp_box";
	p4.className="mp_box_sprite mp_box";
}

/* Mudar Classes */
function MudarMPbox(objecto) {
	document.getElementById("pagamento").innerHTML='';
	ClearBoxesMP();
	var elemento = document.getElementById(objecto.id);
	elemento.className="mp_box_sprite_selected mp_box_selected";
	CarregarPacotesDisponiveis(objecto.id);
}

function MudarPack(objecto) {
	ClearBoxesPKS();
	var elemento = document.getElementById(objecto.id);
	elemento.className="mp_box_sprite_selected mp_box_selected";
	CarregarFormulario();
}