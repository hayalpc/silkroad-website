/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */

setInterval(function(){serverTime()},1000);

function serverTime() {
    var d = new Date();
    document.getElementById("tServerTime").innerHTML = d.toLocaleTimeString();
}

$(".dropdown-menu li a").click(function(){
    var selText = $(this).text();
    $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});