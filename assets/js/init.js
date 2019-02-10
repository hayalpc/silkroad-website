// Initialize JavaScript 68f5272 89e9642 6b063671 daf4c74efd
// MT2Portugalia
// Edited By MadTiago
// -------------------------------------------------------
// CSS Hax
// -------------------------------------------------------

$("#navbar ul li:last").addClass('noborder');
$(".sb-ranking tr:even,.fullTable tr:even").addClass('odd');
$(".sb-ranking tr:odd,.fullTable tr:odd").addClass('even');

// -------------------------------------------------------
// Fading
// -------------------------------------------------------

var fadeDuration = 300;

$('.navbar a,a.ilink,.btn,.btn2,.bar,.screenshots a img,.sb-special, #topbar .right a img').hoverIntent(
	function() {$(this).animate({ opacity: '1.00' }, fadeDuration);}, 
	function() {$(this).animate({ opacity: '0.7' }, fadeDuration);}
);

$('#header #logo img,#sbvid').hoverIntent(function() {
  $(this).animate({ opacity: '0.85' }, fadeDuration);
}, function() {
  $(this).animate({ opacity: '1.0' }, fadeDuration);  
});

// -------------------------------------------------------
// FancyBox
// -------------------------------------------------------

$("#sbvid").fancybox({
	'overlayColor' : '#000',
	'width'				: '85%',
	'height'			: '85%',
	'autoScale'			: true,
	'transitionIn'		: 'none',
	'transitionOut'		: 'none',
	'type'				: 'iframe'
});

$("a[rel=screenshots]").fancybox({
	'overlayColor' : '#000',
	'transitionIn'		: 'none',
	'transitionOut'		: 'none',
	'titlePosition' 	: 'over',
	'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
		return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
	}
});

$("a[rel=itemshop_menu]").fancybox({
	'padding'       : 0, 
	'autoScale'     : false, 
	'transitionIn'  : 'none', 
	'transitionOut' : 'none', 
	'title'     	: 'Market Menüsü', 
	'width'    		: 740, 
	'height'        : 550,
	'showCloseButton': true,
	'type'			:'iframe',
	'overlayColor'	: '#000'
});

$("a[rel=itemshop]").fancybox({
	'padding'       : 0, 
	'autoScale'     : false, 
	'transitionIn'  : 'none', 
	'transitionOut' : 'none', 
	'title'     	: 'Banka Hesaplarımız', 
	'width'    		: 740, 
	'height'        : 550,
	'showCloseButton': true,
	'type'			:'iframe',
	'overlayColor'	: '#000'
});

$("a[rel=carregar]").fancybox({
	'padding'       : 0, 
	'autoScale'     : false, 
	'transitionIn'  : 'none', 
	'transitionOut' : 'none', 
	'title'     	: 'DevilOnline.NET | Market', 
	'width'    		: 740, 
	'height'        : 490,
	'showCloseButton': true,
	'type'			:'iframe',
	'overlayColor'	: '#000'
});

// -------------------------------------------------------
// Slider 
// -------------------------------------------------------

$('#slider').anythingSlider({
	buildArrows : false,
	hashTags: false,
	animationTime: 200,
	delay: 3000,
	easing: "easeInOutExpo"
});