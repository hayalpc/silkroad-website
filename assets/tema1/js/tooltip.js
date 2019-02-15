this.tooltip = function(){			
		xOffset = 10;
		yOffset = 20;			
	$(".tooltip").hover(function(e){											  
		this.t = this.title;
		this.title = "";									  
		$("body").append("<p id='tooltip'>"+ this.t +"</p>");
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");		
    },
	function(){
		this.title = this.t;		
		$("#tooltip").remove();
    });	
	$(".tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

this.tooltip_registo = function(){
	/* USER ID */
	$(".tooltip_registo_uid").focus(function(e){ $("#reg_uid").addClass("tooltip_reg").html(this.alt); });
	$(".tooltip_registo_uid").blur(function(e){	$("#reg_uid").removeClass("tooltip_reg").html(""); });
	/* USER NAME */
	$(".tooltip_registo_uname").focus(function(e){ $("#reg_uname").addClass("tooltip_reg").html(this.alt); });
	$(".tooltip_registo_uname").blur(function(e){ $("#reg_uname").removeClass("tooltip_reg").html(""); });
	/* PASSWORD */
	$(".tooltip_registo_upass").focus(function(e){ $("#reg_upass").addClass("tooltip_reg").html(this.alt); });
	$(".tooltip_registo_upass").blur(function(e){ $("#reg_upass").removeClass("tooltip_reg").html(""); });
	/* EMAIL */
	$(".tooltip_registo_uemail").focus(function(e){ $("#reg_uemail").addClass("tooltip_reg").html(this.alt); });
	$(".tooltip_registo_uemail").blur(function(e){ $("#reg_uemail").removeClass("tooltip_reg").html(""); });
	/* SOCIAL ID */
	$(".tooltip_registo_usid").focus(function(e){ $("#reg_usid").addClass("tooltip_reg").html(this.alt); });
	$(".tooltip_registo_usid").blur(function(e){ $("#reg_usid").removeClass("tooltip_reg").html(""); });
			
};

// 68f52 7289e96 426b06 3671d af4c74efd

this.tooltip2 = function(){			
		xOffset = 10;
		yOffset = 20;			
	$(".tooltip2").hover(function(e){											  
		this.t = this.title;
		this.title = "";
		var broken = this.t.split(":");
		var VotePoints = broken[3];
		if(VotePoints == 0){
		var VotePointUitkomst = "";	
		} else {
		var VotePointUitkomst = "<b>"+ broken[3]+"</b> Vote Points<br>";	
		}
		$("body").append("<div id='tooltip2'></a><b>"+ broken[0] +"</b><br><i>"+ broken[1] +"</i><br><br><img src=\"images/items/"+broken[2]+".png\"><br><br><b>Costs:</b><br>"+ VotePointUitkomst +"<b>"+broken[5]+"</b> Donator Points</div>");
		$("#tooltip2")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");		
    },
	function(){
		this.title = this.t;		
		$("#tooltip2").remove();
    });	
	$(".tooltip2").mousemove(function(e){
		$("#tooltip2")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};


$(document).ready(function(){
	tooltip();
	tooltip_registo();
	tooltip2();
});