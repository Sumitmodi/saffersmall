jQuery(window).ready(function($) {
    $('#carousel4').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 2000,
		animationSpeed:1000,
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:225,
        itemMargin: 15,
		//maxItems: 3,
		//move:1,
     	asNavFor: '#slider'
    });
	});

jQuery(window).ready(function($) {
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: false,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 6,
		move:1,
        
    });
	});


jQuery(window).ready(function($) {
    $('#carousel1').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 4000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 6,
		move:1,
        
    });
	});

jQuery(window).ready(function($) {
    $('#carousel2').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 5000,
		animationSpeed:1000,
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		move:1,
        
    });
	});

jQuery(window).ready(function($) {
    $('#carousel3').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 4,
		move:1,
        
    });
	});
jQuery(window).ready(function($) {
    $('#carousel7').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 4,
		move:1,
        
    });
	});
	
jQuery(window).ready(function($) {
	$('#bus1').click(function(e){
				e.preventDefault();

    $('#carousel8').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 4,
		move:1,
        
    });
	});	$('#audio1').click(function(e){
		e.preventDefault();
    $('#carousel9').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 4,
		move:1,
        
    });
	});	$('#cd1').click(function(e){
				e.preventDefault();
    $('#carousel10').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 18,
		//maxItems: 4,
		move:1,
        
    });
	});
	});
jQuery(window).ready(function($) {
    $('#search_carousel').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        animationLoop: true,
 		slideshow: true,
     	slideshowSpeed: 3000,
		animationSpeed:1000,
	//	smoothHeight: true,    
        prevText: "",           //String: Set the text for the "previous" directionNav item
        nextText: "",
	    itemWidth:195,
        itemMargin: 15,
		//maxItems: 4,
		move:1,
        
    });
	});

	jQuery(window).ready(function($) {
     $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: false,
        prevText: "", //String: Set the text for the "previous" directionNav item
        nextText: "", //String: Set the text for the "next" directionNav item
        animationLoop: true,
        slideshow: true,
		smoothHeight: true,    
     	slideshowSpeed: 3000,
		animationSpeed:1000,
		//move:1,
        sync: "#carousel4",
        start: function(slider) {
            $('body').removeClass('loading');
        }
    });
});


/*	slider*/
	jQuery(window).ready(function($) {
     $('#banner').flexslider({
        animation: "slide",
        controlNav: false,
        directionNav: true,
        prevText: "", //String: Set the text for the "previous" directionNav item
        nextText: "", //String: Set the text for the "next" directionNav item
        animationLoop: true,
        slideshow: true,
        sync: "#slider",
        start: function(slider) {
            $('body').removeClass('loading');
        }
    });
});

jQuery(document).ready(function($) {

function steps(step){
	$(step).click(function(e){
		$('.nav.nav-tabs li.active').removeClass('active').next().addClass('active');	
		e.preventDefault();
		});
		
		}
	steps('#step1');	
	steps('#step2');	
	steps('#step3');	
	steps('#step4');	
	
	$('.nav-wrap .left-nav .navbar-nav > li').hover(function(){
		$(this).children('ul').stop().slideToggle();		
		});
		
});

jQuery(document).ready(function($) {
	var availableTags = [
	"ActionScript",
	"AppleScript",
	"Asp",
	"BASIC",
	"C",
	"C++",
	"Clojure",
	"COBOL",
	"ColdFusion",
	"Erlang",
	"Fortran",
	"Groovy",
	"Haskell",
	"Java",
	"JavaScript",
	"Lisp",
	"Perl",
	"PHP",
	"Python",
	"Ruby",
	"Scala",
	"Scheme"
];

/*$( "#autocomplete" ).autocomplete({
	source: availableTags
});*/

});


jQuery(document).ready(function($) {

    $('*[data-animate-to]').each(function() {
        var _this = $(this);
        _this.addClass('animate').waypoint(function() {
            var _animateTo = $(this).attr('data-animate-to');
            $(this).removeClass('animate').addClass('animated').addClass(_animateTo);
        }, {
            offset: '85%',
            triggerOnce: false
        });
    });
});



jQuery( document ).ready(function($) {
// Show or hide the sticky footer button
			$(window).scroll(function() {
				if ($(this).scrollTop() > 200) {
					$('.go-top').fadeIn(200);
					
				} else {
					$('.go-top').fadeOut(200);
				}
			});
			
			// Animate the scroll to top
			$('.go-top').click(function(event) {
				event.preventDefault();
				
				$('html, body').animate({scrollTop: 0}, 500);
			})
		   });
		   
		   
		   
