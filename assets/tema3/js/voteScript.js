var time = 5;
var banner = 1;

function openUrl(id) {
	reset_timer();
	vote_window = window.open("/vote/" + id , "vote_window", "width=1024, height=860, scrollbars=yes, location=0, closeCallback=focus()");
	return false;
}

function reset_timer() {
	time = 5;
	time_loop();
}

function time_loop() {
	if (time > 0) {
		document.getElementById("response").innerHTML = "Voting will be checked in  "+time+" seconds.";
		time--;
		setTimeout('time_loop()', 1000);
 	} else {
		if (vote_window.closed){
			document.getElementById("response").innerHTML = "Checking cancelled, becouse you closed voting window.";
		}
		vote_window.validate();
		validate();
	}
}

function validate() {
	/* buffer */
}

function reward() {
	var ajaxRequest;
	try {
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				alert("Sorry, but your browser doesn't support the Ajax, please upgrade your browser and try again.");
				return false;
			}
		}
	}
	ajaxRequest.onreadystatechange = function() {
		if (ajaxRequest.readyState == 1){
			document.getElementById("response").innerHTML = "Checking...";
			
		}
		if (ajaxRequest.readyState == 4){
			document.getElementById("response").innerHTML = ajaxRequest.responseText;
		}
	}
	var button = document.getElementById("button").value;
	alert('You have been rewarded - xxx silk');
	ajaxRequest.open("GET", "/vote/reward/submit" + button, true);
	ajaxRequest.send(null);
}