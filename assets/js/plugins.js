(function($) {
	$.fn.resizeControl = function(){
		
		var el_ratio = $(this).attr("ratio");
		var el_width = $(this).width();
		
		var el_height =  el_ratio * el_width;
		$(this).attr("height",el_height);
			
	}
	
	$.fn.carousel = function(){
		
		var speed = $(this).attr("data-autorotate");
		var $wrap = $(this),
			$slider    = $wrap.find(".slider"),
			$slide     = $wrap.find(".slide"),
			slidenum   = $slide.length,
			transition = "margin-left 0.5s ease";
		
		$wrap
			.css({
				"overflow"           : "hidden",
				"width"              : "100%"
			});
			
		$slider
			.css({
				"margin-left"         : "0px",
				"float"              : "left",
				"width"              : 100 * slidenum + "%",
				"-webkit-transition" : transition,
				"-moz-transition"    : transition,
				"-ms-transition"     : transition,
				"-o-transition"      : transition,
				"transition"         : transition
			});
			
		$slide
			.css({
				"float": "left",
				width: (100 / slidenum) + "%"
			});
		
		var i = 1;
		setInterval(function() {
			if(i < slidenum){
				var margin = parseInt($slider.css("margin-left"));
				var width = $slide.width();
				margin_new = margin - width;
				$slider.css("margin-left", margin_new+'px');
				i++;
			} else {
				$slider.css("margin-left","0px");
				i = 1;
			}
		},speed);
	}
}) (jQuery);